<?php
/**
 * @version		$Id: splitmodules.php July 18th, 2011 18:28:38Z OmegaTheme:TrungDam $
 * @package		OmegaTheme Joomla Template
 * @subpackage	Mega EThan
 * @author		OmegaTheme (services@omegatheme.com)
 * @link 		http://omegatheme.com
 * @copyright	Copyright (C) 2008 - 2011 OmegaTheme
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function splitmodules($template, $array_modules, $totalwidth=100, $firstwidth=0) {
	// for example to call this function  
	//$spotlight = array ('user1','user2','top','user5');
	//$botsl = splitmodules($this,$spotlight,99,22);
	$modules = array();
	$modules_s = array();
	
	foreach ($array_modules as $position) {
		if ($template->countModules($position) ){
			$modules_s[] = $position;
		}
	}
	
	if (count($modules_s) == 0) return null;
	
	if ($firstwidth) {
		if (count($modules_s)>1) {
			$width = round(($totalwidth-$firstwidth)/(count($modules_s)-1),1) . "%";
			$firstwidth = $firstwidth . "%";
		} else {
			$firstwidth = $totalwidth . "%";
		}
	} else {
		$width = round($totalwidth/(count($modules_s)),1) . "%";
		$firstwidth = $width;
	}
	if (count($modules_s) > 1) {
		$modules[$modules_s[0]]['class'] = ' firstbox';
		$modules[$modules_s[0]]['width'] = $firstwidth;
		for ($i = 1; $i < count($modules_s); $i++) {				
			if ($i < count($modules_s) - 1) {
				$modules[$modules_s[$i]]['class'] = ' midbox';
			} else $modules[$modules_s[$i]]['class'] = ' lastbox';
			
			$modules[$modules_s[$i]]['width'] = $width;
		}
	} elseif (count($modules_s) == 1) {
		$modules[$modules_s[0]]['width'] = '100%';
		$modules[$modules_s[0]]['class'] = '';
	}
	return $modules;
}
//check IE7 browser
function ie7() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	if (stristr($agent, 'msie 7')) return true;
	return false;
}

//check IE6 browser
function ie6() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	if (stristr($agent, 'msie 6')) return true;
	return false;
}
?>
