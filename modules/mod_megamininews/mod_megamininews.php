<?php
/**
 # mod_megamininews - Mega Mini News Module for Joomla! 1.6
 # author 		OmegaTheme.com
 # copyright 	Copyright(C) 2011 - OmegaTheme.com. All Rights Reserved.
 # @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Website: 	http://omegatheme.com
 # Technical support: Forum - http://omegatheme.com/forum/
**/
/**------------------------------------------------------------------------
 * file: mod_megamininews.php 1.6.0 00001, March 2011 12:00:00Z OmegaTheme $
 * package:	Mega Mini News Module
 *------------------------------------------------------------------------*/
//No direct access!
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$doc = &JFactory::getDocument();
$doc->addStyleSheet(JURI::base().'/modules/mod_megamininews/css/layout.css');

$list = modMegaMiniNewsHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_megamininews', $params->get('layout', 'default'));