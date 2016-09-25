<?php
/**
  * @package plg_simpleqrcodegenerator
  * @version 1.0 March 4, 2012
  * @author Alexios Ntounas http://www.ntounas.gr
  * @copyright Copyright (C) 2010 ntounas.gr. All Rights Reserved.
  * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  **/
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport('joomla.plugin.plugin');


class plgContentSimpleQRCodeGenerator extends JPlugin
{
	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentPrepare($context, &$article, &$params, $limitstart=0) {
		$regex = "#{qrcodegenerator}(.*?){/qrcodegenerator}#s";

		// Find all instances
		if (!preg_match_all($regex, $article->text, $matches)) {
			return;
		}

		// Get plugin parameters
		$qrsize = $this->params->get('size', '100');
		$align = $this->params->get('align', '');

		// Replace all matches
		$count = count($matches[0]);
		for ($i = 0; $i < $count; $i++) {
			// Encode match
			$encoded = urlencode($matches[1][$i]);

			// Create QR Code URL
			$qrimage = 'https://chart.googleapis.com/chart?chs='.$qrsize.'x'.$qrsize.'&cht=qr&chl='.$encoded;

			// Create QR Code image
			$qr_src_code = '<img src="'.$qrimage.'" style="border:2px solid black" align="'.$align.'" />';

			// Replace tags in article
			$article->text = str_replace($matches[0][$i], $qr_src_code, $article->text);
		}
	}
}
?>
