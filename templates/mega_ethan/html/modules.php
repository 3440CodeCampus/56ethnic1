<?php
/**
 * @version		$Id: modules.php July 18th, 2011 18:28:38Z OmegaTheme:TrungDam $
 * @package		OmegaTheme Joomla Template
 * @subpackage	Mega EThan
 * @author		OmegaTheme (services@omegatheme.com)
 * @link 		http://omegatheme.com
 * @copyright	Copyright (C) 2008 - 2011 OmegaTheme
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php
function modChrome_megaxhtml($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
			<div class="module-content">
			<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
} ?>

<?php
function modChrome_megaCustom($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
} ?>

