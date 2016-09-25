<?php
/**
 * @version		$Id: default.php July 01, 2011 18:28:38Z OmegaTheme:TrungDam $
 * @package		OmegaTheme Joomla Module
 * @subpackage	Mega EThan
 * @author		OmegaTheme (services@omegatheme.com)
 * @link 		http://omegatheme.com
 * @copyright	Copyright (C) 2008 - 2011 OmegaTheme
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<object width="<?php echo $params->get('videoWidth'); ?>" height="<?php echo $params->get('videoHeight'); ?>">
	<param name="movie" value="http://www.youtube.com/v/OuvXLAA07jY?version=3&amp;hl=en_US" />
	<param name="allowFullScreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<embed
		type="application/x-shockwave-flash"
		width="<?php echo $params->get('videoWidth'); ?>"
		height="<?php echo $params->get('videoHeight'); ?>"
		src="<?php echo $params->get('videoUrl'); ?>?version=3&amp;hl=en_US"
		allowscriptaccess="always"
		allowfullscreen="true"></embed>
</object>
