<?php
/*
* @Author: Nurte
* @package www.nurte.pl Nurte Google AdSense
* @copyright Copyright (C) 2010 Nurte All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @Version 1.9.0.0
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.plugin.plugin');
	
class plgContentNurte_google_adsense extends JPlugin
{
	function onPrepareContent( $article, $params )
	{
		$ads1text 		= $this->params->get('ads1text');
		$ads1catids		= $this->params->get('ads1catids');
		$ads1artids_array	= explode( ';', trim($this->params->get('ads1artids')));
		$ads1positions		= $this->params->get('ads1positions');
		$ads1frontpage		= $this->params->get('ads1frontpage',0);
		$ads1categoryview	= $this->params->get('ads1categoryview',0);
		$ads1align		= $this->params->get('ads1align','right');
		$ads1_to_guest_only	= $this->params->get('ads1_to_guest_only',0);

		$ads2text	 	= $this->params->get('ads2text','');
		$ads2catids		= $this->params->get('ads2catids');
		$ads2artids_array	= explode( ';', trim($this->params->get('ads2artids')));
		$ads2positions		= $this->params->get('ads2positions');
		$ads2frontpage		= $this->params->get('ads2frontpage',0);
		$ads2categoryview	= $this->params->get('ads2categoryview',0);
		$ads2align		= $this->params->get('ads2align','right');
		$ads2_to_guest_only	= $this->params->get('ads2_to_guest_only',0);

		$ads3text	 	= $this->params->get('ads3text','');
		$ads3catids		= $this->params->get('ads3catids');
		$ads3artids_array	= explode( ';', trim($this->params->get('ads3artids')));
		$ads3positions		= $this->params->get('ads3positions');
		$ads3frontpage		= $this->params->get('ads3frontpage',0);
		$ads3categoryview	= $this->params->get('ads3categoryview',0);
		$ads3align		= $this->params->get('ads3align','right');
		$ads3_to_guest_only	= $this->params->get('ads3_to_guest_only',0);

		$nga_ip_array 		= explode( ';', trim( $this->params->get( 'nga_ip_list' ) ) );
		$alternate_content	= trim($this->params->get('nga_alternate_content',''));
		$okIPflag 		= 1;	

		if($nga_ip_array){
			$userIP = $this->getip();
			if( is_array( $nga_ip_array ) ) {        
				foreach($nga_ip_array as $ip_address) { 
					if ($userIP == trim($ip_address)) {
						$okIPflag = 0;
					}
				}
			} else {	
				if ($userIP == trim($nga_ip_array)) {
					$okIPflag = 0;
				}
			}	
		}

		$user = &JFactory::getUser();

		$this->catId = -1;
		$view = JRequest::getCmd('view'); 
		if($view == 'category') $this->catId = JRequest::getInt('id');
		if($view == 'article' || $view == 'featured')  $this->catId = $article->catid;

		$this->flag1	= false;	
		if ($ads1text) {
			if(!$okIPflag) $ads1text = $alternate_content;

			$this->ads1text	= "<p style=\"text-align: ".$ads1align.";\">".$ads1text."</p>";

			$this->flag1 = $this->checkCatID($ads1catids, $this->catId);

			if ($view == 'featured' && $ads1frontpage == 0) 	$this->flag1 = false;
			if ($view == 'category' && $ads1categoryview == 0) 	$this->flag1 = false;
			if (!$user->guest && $ads1_to_guest_only == 1) 		$this->flag1 = false;				
			if ($this->checkArtID($ads1artids_array,$article->id))	$this->flag1 = false;

			$this->ads1placeholder 	= 0;	
			$this->showbefore1 	= 0;
			$this->showtop1		= 0;
			$this->showbottom1	= 0;
			$this->showafter1	= 0;

			if($ads1positions){
				if( is_array( $ads1positions ) ) {        
					foreach($ads1positions as $ads1position) { 
						$this->position(1, $ads1position);
					}
				} else {	
					$this->position(1, $ads1positions);
				}	
			}
		
			if ($this->flag1) {
				if($this->ads1placeholder)
					$article->text = str_replace('{ads1}', $ads1text, $article->text);				
				else	$article->text = str_replace('{ads1}', '', $article->text);
				
				if ($this->catId != -1){
					if($this->showtop1) 	$article->text = $this->ads1text.$article->text; 					
					if($this->showbottom1)	$article->text = $article->text.$this->ads1text; 					
				}
			} else	$article->text = str_replace('{ads1}', '', $article->text);

		} else $article->text = str_replace('{ads1}', '', $article->text);

		$this->flag2	= false;	
		if ($ads2text) {
			if(!$okIPflag) $ads2text = $alternate_content;

			$this->ads2text	= "<p style=\"text-align: ".$ads2align.";\">".$ads2text."</p>";

			$this->flag2 = $this->checkCatID($ads2catids, $this->catId);

			if ($view == 'featured' && $ads2frontpage == 0) 	$this->flag2 = false;
			if ($view == 'category' && $ads2categoryview == 0) 	$this->flag2 = false;
			if (!$user->guest && $ads2_to_guest_only == 1) 		$this->flag2 = false;				
			if ($this->checkArtID($ads2artids_array,$article->id))	$this->flag2 = false;

			$this->ads2placeholder 	= 0;	
			$this->showbefore2 	= 0;
			$this->showtop2		= 0;
			$this->showbottom2	= 0;
			$this->showafter2	= 0;

			if ($ads2positions){     
				if( is_array( $ads2positions ) ) {        
					foreach($ads2positions as $ads2position) { 
						$this->position(2, $ads2position);
					}
				} else {	
					$this->position(2, $ads2positions);
				}	
			}

			if ($this->flag2) {
				if($this->ads2placeholder)
					$article->text = str_replace('{ads2}', $ads2text, $article->text);				
				else	$article->text = str_replace('{ads2}', '', $article->text);

				if ($this->catId != -1){
					if($this->showtop2) 	$article->text = $this->ads2text.$article->text; 					
					if($this->showbottom2)	$article->text = $article->text.$this->ads2text; 					
				}
			} else $article->text = str_replace('{ads2}', '', $article->text);

		} else $article->text = str_replace('{ads2}', '', $article->text);

		$this->flag3	= false;	
		if ($ads3text) {
			if(!$okIPflag) $ads3text = $alternate_content;

			$this->ads3text	= "<p style=\"text-align: ".$ads3align.";\">".$ads3text."</p>";

			$this->flag3 = $this->checkCatID($ads3catids, $this->catId);

			if ($view == 'featured' && $ads3frontpage == 0) 	$this->flag3 = false;
			if ($view == 'category' && $ads3categoryview == 0) 	$this->flag3 = false;
			if (!$user->guest && $ads3_to_guest_only == 1) 		$this->flag3 = false;				
			if ($this->checkArtID($ads3artids_array,$article->id))	$this->flag3 = false;

			$this->ads3placeholder 	= 0;	
			$this->showbefore3 	= 0;
			$this->showtop3		= 0;
			$this->showbottom3	= 0;
			$this->showafter3	= 0;

			if ($ads3positions){     
				if( is_array( $ads3positions ) ) {        
					foreach($ads3positions as $ads3position) { 
						$this->position(3, $ads3position);
					}
				} else {	
					$this->position(3, $ads3positions);
				}	
			}

			if ($this->flag3) {
				if($this->ads3placeholder)
					$article->text = str_replace('{ads3}', $ads3text, $article->text);				
				else	$article->text = str_replace('{ads3}', '', $article->text);

				if ($this->catId != -1){
					if($this->showtop3) 	$article->text = $this->ads3text.$article->text; 					
					if($this->showbottom3)	$article->text = $article->text.$this->ads3text; 					
				}
			} else	$article->text = str_replace('{ads3}', '', $article->text);

		} else $article->text = str_replace('{ads3}', '', $article->text);
	}

	function position($ads, &$param1){
		if($ads == 1){
			if($param1 == 'placeholder')	$this->ads1placeholder 	= 1;	
			if($param1 == 'before') 	$this->showbefore1 	= 1;
			if($param1 == 'top') 		$this->showtop1		= 1;
			if($param1 == 'bottom') 	$this->showbottom1	= 1;
			if($param1 == 'after') 		$this->showafter1	= 1;
		}
		if($ads == 2){
			if($param1 == 'placeholder')	$this->ads2placeholder	= 1;
			if($param1 == 'before') 	$this->showbefore2	= 1;
			if($param1 == 'top') 		$this->showtop2		= 1;
			if($param1 == 'bottom') 	$this->showbottom2	= 1;
			if($param1 == 'after') 		$this->showafter2	= 1;
		}
		if($ads == 3){
			if($param1 == 'placeholder')	$this->ads3placeholder	= 1;
			if($param1 == 'before') 	$this->showbefore3	= 1;
			if($param1 == 'top') 		$this->showtop3		= 1;
			if($param1 == 'bottom') 	$this->showbottom3	= 1;
			if($param1 == 'after') 		$this->showafter3	= 1;
		}
	} 

	function checkCatID(&$catids, &$catId){
		if ($catids){     
			if( is_array( $catids ) ) {        
				foreach($catids as $catid) { 
					if( $catid == $catId ) return true;
				}
			} else {	
				if( $catids == $catId ) return true;
			}	
		}
		if ($catId == -1) return true;
	}	

	function checkArtID(&$artids, &$artId){
		if ($artids){     
			if( is_array( $artids ) ) {        
				foreach($artids as $artid) { 
					if( $artid == $artId ) return true;
				}
			} else {	
				if( $artids == $artId ) return true;
			}	
		}
	}	

	function onBeforeDisplayContent(&$article, &$params){
		$ads = '';
		if ($this->catId != -1){
			if( $this->flag1 && $this->showbefore1)
				$ads = $this->ads1text;
			if( $this->flag2 && $this->showbefore2)
				$ads .= $this->ads2text;
			if( $this->flag3 && $this->showbefore3)
				$ads .= $this->ads3text;
		}
		return $ads;
	}

	function onAfterDisplayContent(&$article, &$params){
		$ads = '';
		if ($this->catId != -1){
			if( $this->flag1 && $this->showafter1)
				$ads = $this->ads1text;
			if( $this->flag2 && $this->showafter2)
				$ads .= $this->ads2text;
			if( $this->flag3 && $this->showafter3)
				$ads .= $this->ads3text;
		}
		return $ads;
	}

	//joomla 1.6 compatibility code 
	public function onContentPrepare($context, &$article, &$params, $limitstart = 0){
		$view = JRequest::getCmd('view');
		if($view == 'article'){
			$this->onPrepareContent( $article, $params );
		}
        }

	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart = 0){ 
		$view = JRequest::getCmd('view');
		if($view == 'featured' || $view == 'category'){
			$article->text = $article->introtext;
			$this->onPrepareContent( $article, $params );
			$article->introtext = $article->text;
		}

		$result = $this->onBeforeDisplayContent($article, $params);
        	return $result;
        }

	public function onContentAfterDisplay($context, &$article, &$params, $limitstart = 0){
		$result = $this->onAfterDisplayContent($article, $params);
        	return $result;
        }

	function validip($ip) {
		if (!empty($ip) && ip2long($ip)!=-1) {
	 		$reserved_ips = array (
	 			array('0.0.0.0','2.255.255.255'),
	 			array('10.0.0.0','10.255.255.255'),
		 		array('127.0.0.0','127.255.255.255'),
		 		array('169.254.0.0','169.254.255.255'),
		 		array('172.16.0.0','172.31.255.255'),
		 		array('192.0.2.0','192.0.2.255'),
		 		array('192.168.0.0','192.168.255.255'),
		 		array('255.255.255.0','255.255.255.255')
 			);
			foreach ($reserved_ips as $r) {
 				$min = ip2long($r[0]);
		 		$max = ip2long($r[1]);
	 			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
 			}
	 		return true;
	 	} else {
 			return false;
	 	}
	}
 
	function getip() {
		if (isset($_SERVER["HTTP_CLIENT_IP"])){
			if ($this->validip($_SERVER["HTTP_CLIENT_IP"])) {
	 			return $_SERVER["HTTP_CLIENT_IP"];
	 		}
		}
	
	 	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
				if ($this->validip(trim($ip))) {
 					return $ip;
	 			}
	 		}
		}

	 	if (isset($_SERVER["HTTP_X_FORWARDED"])){
			if ($this->validip($_SERVER["HTTP_X_FORWARDED"])) {
	 			return $_SERVER["HTTP_X_FORWARDED"];
	 		} 
		}

	 	if (isset($_SERVER["HTTP_FORWARDED_FOR"])){
			if ($this->validip($_SERVER["HTTP_FORWARDED_FOR"])) {
	 			return $_SERVER["HTTP_FORWARDED_FOR"];
	 		}
		}
	
		if (isset($_SERVER["HTTP_FORWARDED"])){
			if ($this->validip($_SERVER["HTTP_FORWARDED"])) {
	 			return $_SERVER["HTTP_FORWARDED"];
	 		}
		}

		return $_SERVER["REMOTE_ADDR"];
	}
}