<?php
/**
 * @package 		Mega Horizontal Scroller for Joomla! 1.5
 * @version 		default.php 001 2010-11-12 23:26:33Z $
 * @author 			THEME EXTENSIONS (services@omegatheme.com)
 * @copyright 		8 - 2011 - OMEGATHEME EXTENSIONS
 * @license 			PL http://www.gnu.org/copyleft/gpl.html
**/

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<div id="gallery_wrap" class="<?php echo $params->get('moduleclass_sfx');?>" style="width: <?php echo $params->get('panel_width')?>px;">
	<div id="photos" class="galleryview">
		<div class="slide-item">
			<?php foreach ($lists as $item): ?>
			<div class="panel">
				<div class="slide-image">
					<?php echo $item->megaImage;?>
				</div>
				<div class="panel-overlay">
					<div class="slide-content-wrap">
						<h2 style="color: <?php echo $params->get('overlay_heading_color'); ?>;"><?php echo $item->megaTitle;?></h2>
						<p><?php echo $item->displayIntrotext; ?></p>
						<p class="readmore_link"><?php echo $item->displayReadmore;?></p>
					</div>
				</div>
			</div>
			<?php endforeach?>
		</div>
		
		<div class="slide-filmstrip">
		<?php 
			if ($params->get('show_filmstrip', 1) == 1) {
				echo '<ul class="filmstrip">';
				foreach ($lists as $item) {
					echo '<li>'.$item->megaImageThumbnail.'</li>';
				}
				echo '</ul>';
			} else {
				echo '<div class="filmstrip"></div>';
			}
		?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var j = jQuery.noConflict();
	j(document).ready(function(){
		j('#photos').galleryView({
			border: '<?php echo $params->get('border', 'none')?>',
			panel_width: <?php echo $params->get('panel_width', 960)?>,
			panel_height: <?php echo $params->get('panel_height', 268)?>,
			frame_width: <?php echo $params->get('frame_width', 72)?>,
			frame_height: <?php echo $params->get('frame_height', 36)?>,
			background_color: '<?php echo (($params->get('frame_background_type') == 1) ? $params->get('backgroundcolor','#C8CEDE') : '0') ?>',
			show_captions: <?php echo ($params->get('show_captions', 0) == 1 ? 'true':'false') ?>,
			caption_text_color: '<?php echo $params->get('caption_text_color', '#FFFFFF')?>',
			filmstrip_position: '<?php echo $params->get('filmstrip_position', 'bottom')?>',
			frame_space_top: <?php echo $params->get('frame_space_top', 0)?>,
			overlay_position: '<?php echo $params->get('overlay_position', 'top')?>',
			overlay_height: <?php echo $params->get('overlay_height', 190)?>,
			overlay_width: <?php echo $params->get('overlay_width', 456)?>,
			overlay_color: '<?php echo $params->get('overlay_color', '#000000')?>',
			overlay_opacity: <?php echo $params->get('overlay_opacity', 0.6)?>,
			overlay_text_color: '<?php echo $params->get('overlay_text_color', '#4F4F4F')?>',
			overlay_font_size: '<?php echo $params->get('overlay_font_size', '13px')?>',
			overlay_heading_color: '<?php echo $params->get('overlay_heading_color', '#3D3D3D')?>',
			overlay_link_color: '<?php echo $params->get('overlay_link_color', '#FF8A00')?>',
			transition_speed: <?php echo $params->get('transition_speed', 1000)?>,
			transition_interval: <?php echo $params->get('transition_interval', 4000)?>,
			easing: '<?php echo $params->get('easing','easeInOutBack')?>',
			pause_on_hover: true,
			nav_theme: 'custom',
			overlay_nav_height: <?php echo $params->get('overlay_nav_height', 39)?>,
			overlay_nav_width: <?php echo $params->get('overlay_nav_width', 39)?>
		});
		j(".megaresizeme").aeImageResize({height: <?php echo intval($params->get('frame_height')) ?>, width: <?php echo intval($params->get('frame_width')*2)?>});
		j(".megathumb").thumbs();
		j(".megathumbcontainer").css({
			'width': <?php echo intval(trim($params->get('frame_width'))) - 4;?> +'px',
			'height': <?php echo intval(trim($params->get('frame_height'))) - 4;?> +'px',
			'border': '2px #999999 solid'
		});	
		j("#gallery_wrap h2").css({
			'color': '<?php echo $params->get('overlay_heading_color','#3D3D3D'); ?>'
		});
	});
</script>