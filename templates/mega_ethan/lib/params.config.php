<?php
/**
 * @version		$Id: params.config.php July 18th, 2011 18:28:38Z OmegaTheme:TrungDam $
 * @package		OmegaTheme Joomla Template
 * @subpackage	Mega EThan
 * @author		OmegaTheme (services@omegatheme.com)
 * @link 		http://omegatheme.com
 * @copyright	Copyright (C) 2008 - 2011 OmegaTheme
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//The configuration for Width of template
$width_type 		= $this->params->get('width_type');
$width 				= intval($this->params->get('width'));
$width_right 		= intval($this->params->get('width_right'));
$width_content 		= intval(($width - $width_right - 2));

//The configuration for Text and links
$color_text = ($this->params->get('color_text') != '') ? $this->params->get('color_text') : '#000000';
$color_links = ($this->params->get('color_links') != '') ? $this->params->get('color_links') : '#FF8A00';

//The configuration for font-size
$fontSize = ($this->params->get('fontSize') != '') ? '12px' : $this->params->get('fontSize');

$mainContentClass = 'mega-main-content-full';
$wrapContentCss = '';
$wrapRightColCss = '';

if ($this->countmodules('right')) {
	$mainContentClass = 'mega-main-content';
	$wrapContentCss = ' style="width: '.$width_content.'px;"';
	$wrapRightColCss = ' style="width: '.$width_right.'px;"';
}

$megaStyleSheet = '<style type="text/css">body {color: '.$color_text.';font-size: '.$fontSize.';}a {color: '.$color_links.';}.mega-main-content #mega-main-content-wrap {background: #FFFFFF url("'.$this->baseurl.'\/templates\/'.$this->template.'/images/right-module-bg.png") repeat-y '.$width_content.'px 0;}</style>';
