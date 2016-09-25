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

//Parameters
$sbiid = $params->get( 'sbi_id' ); 
if ($sbiid != ''){
	//clean up white space
	$sbiid = trim ($sbiid);

	if (stristr($sbiid, ".html")){
		//call for helper
		$thetext = modSbiRotator::getTheLink($sbiid); 
		}
	else {
		$sbiid = $sbiid.".html";
		//call for helper
		$thetext = modSbiRotator::getTheLink($sbiid); 
		}
	
	}

if ($sbiid = ''){ $thetext = "Please, set the SBI Rotator module properly"; }

echo $thetext;
//I Love coding
?>