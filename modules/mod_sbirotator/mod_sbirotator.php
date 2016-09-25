<?php
/**
* Sbi Rotator - Joomla Module
* Version			: 1.4.3
* Created by		: Yevgeniy Glukhov
* Created on		: v1.0 - October, 2011
* Copyright		: Copyright (C) 2011 - 2012 Yevgeniy Glukhov. All rights reserved.
* License			: GNU General Public License version 2 or later; see LICENSE.txt
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).'/helper.php');

modSbiRotator::theData();
require( JModuleHelper::getLayoutPath( 'mod_sbirotator' ) );

//require JModuleHelper::getLayoutPath('mod_sbirotator', $params->get('layout', 'default'));
?>