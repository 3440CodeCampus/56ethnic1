<?php
/**
 * @version		$Id: index.php July 18th, 2011 18:28:38Z OmegaTheme:TrungDam $
 * @package		OmegaTheme Joomla Template
 * @subpackage	Mega Ethan
 * @author		OmegaTheme.com (services@omegatheme.com)
 * @link 		http://omegatheme.com
 * @copyright	Copyright (C) 2008 - 2011 OmegaTheme.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_ROOT . "/templates/" . $this->template . '/lib/splitmodules.php');
include_once(JPATH_ROOT . "/templates/" . $this->template . '/lib/params.config.php');

JHTML::_('behavior.mootools');
$doc = &JFactory::getDocument();
$doc->addScript(JURI::base() . 'templates/' . $this->template . '/js/megascript.js');
if ($this->countModules('mainmenu')) {
	$doc->addScript(JURI::base() . 'templates/' . $this->template . '/js/dropdown-j17.js');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<?php
	$menu =& JSite::getMenu();
	if ($menu->getActive() == $menu->getDefault()) {
		$home = 'mega-home-page';
	} else {
		$home = '';
	}
?>
<jdoc:include type="head" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/typography.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/customs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/menu.css" rel="stylesheet" type="text/css" />
<?php echo $megaStyleSheet; ?>
</head>
<body id="body-bg">
	<div id="mega-wrapper">
		<div id="mega-header-wrap">
			<?php if ($this->countModules('mainmenu + searchbox')): ?>
			<div id="mega-mainmenu-wrap">
				<?php if ($this->countModules('mainmenu')): ?>
				<div id="mega-mainmenu">
					<div id="main-nav">
						<jdoc:include type="modules" name="mainmenu" style="none" />
					</div>
				</div>
				<?php endif ?>
				<?php if ($this->countModules('searchbox')): ?>
				<div class="mega-search">
					<jdoc:include type="modules" name="searchbox" style="none" />
				</div>
				<?php endif ?>
			</div>
			<?php endif ?>
			<div id="mega-header-top" class="mega-clr">
				<div id="logo">
					<jdoc:include type="modules" name="logo" style="none" />
				</div>
				<?php if ($this->countModules('header-top')): ?>
				<div id="module-top">
					<jdoc:include type="modules" name="header-top" style="none" />
				</div>
				<?php endif ?>
			</div>
			<?php if ($this->countModules('slideshow')): ?>
			<div id="mega-header-slideshow" class="mega-clr">
				<jdoc:include type="modules" name="slideshow" style="none" />
			</div>
			<?php endif ?>
		</div>
		<div id="mega-body-wrap">
			<div id="mega-body-inner" class="<?php echo $mainContentClass; ?>">
				<div id="mega-body-content-wrap">
					<?php
						$bodyTopPositions = array('topbox-1', 'topbox-2');
						$bodyTopModuleWidth = splitmodules($this, $bodyTopPositions, 100);
					?>
					<?php if ($bodyTopModuleWidth): ?>
					<?php if ($this->countModules('topbox-1 + topbox-2')): ?>
					<div id="mega-body-top-wrap">
						<div id="mega-body-top-inner">
							<?php if ($this->countModules('topbox-1')): ?>
							<div class="topbox topbox1 <?php echo $bodyTopModuleWidth['topbox-1']['class']; ?>" style="width: <?php echo $bodyTopModuleWidth['topbox-1']['width']; ?>;">
								<jdoc:include type="modules" name="topbox-1" style="megaCustom" />
							</div>
							<?php endif ?>
							
							<?php if ($this->countModules('topbox-2')): ?>
							<div class="topbox topbox2 <?php echo $bodyTopModuleWidth['topbox-2']['class']; ?>" style="width: <?php echo $bodyTopModuleWidth['topbox-2']['width']; ?>;">
								<jdoc:include type="modules" name="topbox-2" style="megaCustom" />
							</div>
							<?php endif ?>
						</div>
					</div>
					<?php endif ?>
					<?php endif ?>
					<div id="mega-main-content-wrap">
						<div id="<?php echo $mainContentClass; ?>" <?php echo $wrapContentCss; ?>>
							<jdoc:include type="message" />
							<div class="mega-main-content-padding">
								<jdoc:include type="component" />
							</div>
						</div>
						<?php if ($this->countModules('right')): ?>
						<div id="mega-right-wrap" <?php echo $wrapRightColCss; ?>>
							<div id="mega-right-inner">
								<jdoc:include type="modules" name="right" style="megaxhtml" />
							</div>
						</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
		<?php
			$botomPositions = array('botbox-1', 'botbox-2', 'botbox-3', 'botbox-4');
			$bottomModuleWidth = splitmodules($this, $botomPositions, 100);
		?>
		<?php if ($bottomModuleWidth): ?>
		<?php if ($this->countModules('botbox-1 + botbox-2 + botbox-3 + botbox-4')): ?>
		<div id="mega-bottom-wrap" class="mega-clr">
			<?php if ($this->countModules('botbox-1')): ?>
			<div class="botbox botbox1 <?php echo $bottomModuleWidth['botbox-1']['class']; ?>" style="width: <?php echo $bottomModuleWidth['botbox-1']['width']; ?>;">
				<jdoc:include type="modules" name="botbox-1" style="megaxhtml" />
			</div>
			<?php endif ?>
			
			<?php if ($this->countModules('botbox-2')): ?>
			<div class="botbox botbox2 <?php echo $bottomModuleWidth['botbox-2']['class']; ?>" style="width: <?php echo $bottomModuleWidth['botbox-2']['width']; ?>;">
				<jdoc:include type="modules" name="botbox-2" style="megaxhtml" />
			</div>
			<?php endif ?>
			
			<?php if ($this->countModules('botbox-3')): ?>
			<div class="botbox botbox3 <?php echo $bottomModuleWidth['botbox-3']['class']; ?>" style="width: <?php echo $bottomModuleWidth['botbox-3']['width']; ?>;">
				<jdoc:include type="modules" name="botbox-3" style="megaxhtml" />
			</div>
			<?php endif ?>
			
			<?php if ($this->countModules('botbox-4')): ?>
			<div class="botbox botbox4 <?php echo $bottomModuleWidth['botbox-4']['class']; ?>" style="width: <?php echo $bottomModuleWidth['botbox-4']['width']; ?>;">
				<jdoc:include type="modules" name="botbox-4" style="megaxhtml" />
			</div>
			<?php endif ?>
		</div>
		<?php endif ?>
		<?php endif ?>
		<?php if ($this->countModules('copyright')): ?>
		<div id="mega-footer-wrap" class="mega-clr">
			<div class="mega-footer-content">
				<jdoc:include type="modules" name="copyright" style="none" />
			</div>
		</div>
		<?php endif ?>
	</div>
	<jdoc::include type="yourrenderertype" style="yourchromestyle" />
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>