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

	class modSbiRotator {
		
		function theData(){
			include_once "sub1.php";
			}
	
              	function getTheLink($xLink){

	 	include "sub1.php";

		$magic_number = rand(1, 82);
		$bLink = $dbLink[$magic_number][Link];
		$bText = $dbLink[$magic_number][Text];
		$aLink = "<center><a href=' ".$bLink.$xLink." ' target='_blank'>".$bText."</a></center>";
						
		return $aLink;
		}	// getTheLink



}	// classs modSbiRotator 
?>