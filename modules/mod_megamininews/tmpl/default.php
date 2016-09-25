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
 * file: default.php 1.6.0 00001, March 2011 12:00:00Z OmegaTheme $
 * package:	Mega Mini News Module
 *------------------------------------------------------------------------*/
//No direct access!
defined('_JEXEC') or die;
?>

<div class="mega_news">
	<div class="mega_news_i">
		<?php 
		$count = 0;
		foreach ($list as $item) :  ?>
		<?php $count++; ?>
		<div class="mega_items <?php echo ($params->get('count') == $count)?'last-item':''; ?>">
			<!-- Show thumbnails -->
			<?php if($params->get('showthumbnails') == 1){?>
				<div class="mega_thumbs"  style="width:<?php echo $params->get('thumbwidth')?>px; height:<?php echo $params->get('thumbheight')?>px;">
					 <?php 	if($params->get('enablelinkthumb') == 1) {?>
							<a href="<?php echo $item->link; ?>"><?php echo $item->thumbnail ;?></a>
					<?php } else { ?>	
							<?php echo $item->thumbnail?>
					 <?php }?>
				</div>
			<?php } else { ?>
				<?php echo ''; ?>
			<?php } ?>
			<!-- End -->
			 <!-- Show Titles -->
			<div class="mega_articles">
				<?php 	if($params->get('showtitle') == 1) { ?>
					<div class="mega_title">
					 <?php 	if($params->get('enablelinktitle') == 1) { ?>
						 <a href="<?php echo $item->link; ?>" class="title"><?php echo $item->title; ?></a>	
					<?php }else{?>
						<span class="title"><?php echo $item->title; ?></span>
				   <?php }?>
				   </div>
			   <?php } ?>
			    <!-- Show Created Date -->
			   <?php
			   	if ($params->get('show_date') == 1) { 
					echo '<p class="createddate"><span class="mega_date">'; 
					$date = $item->created_date;
					echo JHTML::_('date', $date, $params->get( 'date_format' ));
					echo '</span></p>'; 
				}
			   ?>
			   <!-- Show Content -->
				<div class="mega_content">	<?php echo $item->content; ?></div>
				<!-- Show Readmore -->
				 <?php if($params->get('readmore') == 1) {?>
				<div class="mega_readmore"><a href="<?php echo $item->link; ?>" class="mega_readm"><?php echo JText::_('READMORE') ?></a></div>
				<?php }else {?>
					<?php echo ''; ?>
				<?php } ?>
			</div>
		</div>
		<div class="spaces"></div>
		<?php endforeach; ?>
	</div>
</div>