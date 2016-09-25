<?php
/**
 * @copyright	Copyright (C) 2010 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @version 1.2
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemKeepaliveLight extends JPlugin {

    /**
     * Constructor
     *
     * @access	protected
     * @param	object $subject The object to observe
     * @param	array  $config  An array that holds the plugin configuration
     * @since	1.0
     */
    function __construct(&$subject, $config) {
        parent::__construct($subject, $config);
    }

    /**
     * Preemptively loading a modified JResponse class
     * to allow modification of the X-Content-Encoded-By header
     */
    // onAfterInitialize to beat out any component that might inject headers
    function onAfterInitialise() {
        if (!function_exists('stream_wrapper_register')) {
            error_log('KeepaliveLight: PHP stream wrappers not enabled, you may as well uninstall the keepalivelight package if you cannot enable stream wrappers.');
            return;
        }
        // we only run if JHtmlBehavior isn't already loaded
        if (class_exists('JHtmlBehavior', false)) return;

        $doc = JFactory::getDocument();
        // we don't run in pages that aren't html
        if($doc->getType() != 'html') return true;

        // test if the wrapper has already been registered
        if(!in_array("var", stream_get_wrappers())) { 
            // prepare the var:// stream wrapper
            stream_wrapper_register("var", "VariableStream") or die("Failed to register protocol");
        }
        // new object for Mootools AJAX send method
        $getvars = 'option=com_keepalivelight&tmpl=component';

        // retrieve the jresponse class script
        $filename = JPATH_ROOT . DS . 'libraries' . DS . 'joomla' . DS . 'html' . DS . 'html' . DS . 'behavior.php';
        $response = file_get_contents($filename);

        // identify the specific selection of code  to replace - safe for future versions
        $regexmatch = '/new Request\(\{method: \"get\", url: \"index.php\"\}\).send\(\);/';
        preg_match($regexmatch, $response, $codepos, PREG_OFFSET_CAPTURE);

        // prepare the replacement
        $statement = explode('send(', $codepos[0][0]);
        $statement = $statement[0] . 'send("' . $getvars . '"' . $statement[1];

        // replace the target code with the new code
        $GLOBALS['keepalivelight'] = str_replace($codepos[0][0], $statement, $response);

        // preempt the class
        include 'var://keepalivelight';
    }

}
if (!class_exists('VariableStream', false)) {

    class VariableStream {

        var $position;
        var $varname;

        function stream_open($path, $mode, $options, &$opened_path) {
            $url = parse_url($path);
            $this->varname = $url["host"];
            $this->position = 0;

            return true;
        }

        function url_stat() {
            return true;
        }

        function stream_stat() {
            return true;
        }

        function stream_read($count) {
            $ret = substr($GLOBALS[$this->varname], $this->position, $count);
            $this->position += strlen($ret);
            return $ret;
        }

        function stream_write($data) {
            $left = substr($GLOBALS[$this->varname], 0, $this->position);
            $right = substr($GLOBALS[$this->varname], $this->position + strlen($data));
            $GLOBALS[$this->varname] = $left . $data . $right;
            $this->position += strlen($data);
            return strlen($data);
        }

        function stream_tell() {
            return $this->position;
        }

        function stream_eof() {
            return $this->position >= strlen($GLOBALS[$this->varname]);
        }

        function stream_seek($offset, $whence) {
            switch ($whence) {
                case SEEK_SET:
                    if ($offset < strlen($GLOBALS[$this->varname]) && $offset >= 0) {
                        $this->position = $offset;
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case SEEK_CUR:
                    if ($offset >= 0) {
                        $this->position += $offset;
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case SEEK_END:
                    if (strlen($GLOBALS[$this->varname]) + $offset >= 0) {
                        $this->position = strlen($GLOBALS[$this->varname]) + $offset;
                        return true;
                    } else {
                        return false;
                    }
                    break;

                default:
                    return false;
            }
        }

    }

}