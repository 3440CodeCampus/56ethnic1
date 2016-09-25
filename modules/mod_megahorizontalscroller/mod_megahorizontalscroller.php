<?php
/**
 * @package 	Mega Horizontal Scroller for Joomla! 1.5
 * @version 	$Id: mod_megahorizontalscroller.php 001 2010-11-12 23:26:33Z $
 * @author 		OMEGATHEME EXTENSIONS (services@omegatheme.com)
 * @copyright (C) 2008 - 2011 - OMEGATHEME EXTENSIONS
 * @license 	GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// No direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');
$doc = &JFactory::getDocument();

$doc->addStyleSheet(JURI::root().'modules/mod_megahorizontalscroller/assets/css/style.css');
if ($params->get('load_jquery') == 1) {
	$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery-1.3.2.min.js');
}
$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery.easing.1.3.js');
$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery.timers-1.1.2.js');
$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery.galleryview-1.1.js');
$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery.thum.js');
$doc->addScript(JURI::root().'modules/mod_megahorizontalscroller/assets/js/jquery.ae.image.resize.min.js');

$lists = modMegaHorizontalScroller::getContentList($params);

require(JModuleHelper::getLayoutPath('mod_megahorizontalscroller', $params->get('layout', 'default')));
?>
