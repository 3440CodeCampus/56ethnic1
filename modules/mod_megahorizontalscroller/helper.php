<?php
/**
 * @package 	Mega Horizontal Scroller for Joomla! 1.5
 * @version 	$Id: helper.php 001 2010-11-12 23:26:33Z $
 * @author 		OMEGATHEME EXTENSIONS (services@omegatheme.com)
 * @copyright (C) 2008 - 2011 - OMEGATHEME EXTENSIONS
 * @license 	GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// No direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

$com_path = JPATH_SITE.'/components/com_content/';
require_once $com_path.'router.php';
require_once $com_path.'helpers/route.php';

JModel::addIncludePath($com_path . '/models', 'ContentModel');

abstract class modMegaHorizontalScroller {
	public static function getContentList(&$params)
	{
		// Get an instance of the generic articles model
		$articles = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$article = JModel::getInstance('Article', 'ContentModel');
		
		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$articles->setState('params', $appParams);
		
		// Set the filters based on the module params
		$articles->setState('list.start', 0);
		$articles->setState('list.limit', (int) $params->get('count', 0));
		$articles->setState('filter.published', 1);
		
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$articles->setState('filter.access', $access);
		
		$catids = $params->get('catid');
		
		// Category filter
		if ($catids) {			
			$articles->setState('filter.category_id', $catids);
		}
		
		// Ordering
		$articles->setState('list.ordering', $params->get('article_ordering', 'a.ordering'));
		$articles->setState('list.direction', $params->get('article_ordering_direction', 'ASC'));
		
		$items = $articles->getItems();
		
		// Display options
		$show_introtext = $params->get('show_introtext', 1);
		$introtext_limit = $params->get('introtext_limit', 730);
		$imageDefault = $params->get('image_default', 'modules/mod_megahorizontalscroller/assets/images/default.jpg');
		$linkTitle = $params->get('link_titles', 1);
		$titleColor = $params->get('overlay_heading_color', '#3D3D3D');
		$altReadmore = $params->get('custom_readmore_text', '[...] Read More');
		$showReadmore  = $params->get('show_readmore', 1);
		$linkColor = $params->get('overlay_link_color', '#FF8A00');
		
		// Find current Article ID if on an article page
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');

		if ($option === 'com_content' && $view === 'article') {
			$active_article_id = JRequest::getInt('id');
		} else {
			$active_article_id = 0;
		}
		
		// Prepare data for display using display options
		foreach ($items as &$item)
		{
			$item = $article->getItem($item->id);
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid ? $item->catid .':'.$item->category_alias : $item->catid;
			
			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				// Angie Fixed Routing
				$app	= JFactory::getApplication();
				$menu	= $app->getMenu();
				$menuitems	= $menu->getItems('link', 'index.php?option=com_users&view=login');
				if (isset($menuitems[0])) {
					$Itemid = $menuitems[0]->id;
				} else if (JRequest::getInt('Itemid') > 0) {
					//use Itemid from requesting page only if there is no existing menu
					$Itemid = JRequest::getInt('Itemid');
				}
				
				$item->link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$Itemid);
			}
			
			if ($linkTitle == 0) {
				$item->megaTitle = htmlspecialchars($item->title);
			} else {
				$item->megaTitle = '<a style="color: '.$titleColor.';" href = "'.$item->link.'" title="'.$item->title.'">'.htmlspecialchars($item->title).'</a>';
			}
			
			// Used for styling the active article
			$item->active = $item->id == $active_article_id ? 'active' : '';
			
			preg_match_all('/src="([^"]+)"/i', $item->introtext . $item->fulltext, $matches);
			$imagePath = empty($matches[1][0]) ? $imageDefault : $matches[1][0];
			
			$item->megaImage = '<img src="'.$imagePath.'" width="469px" height="217px" alt="'.$item->title.'" />';
			$item->megaImageThumbnail = '<img src="'.$imagePath.'" width="72px" height="36px" alt="'.$item->title.'" />';
			
			if ($show_introtext) {
				$item->introtext = JHtml::_('content.prepare', $item->introtext);
				$item->introtext = self::_cleanIntrotext($item->introtext);
			}
			
			$item->displayIntrotext = $show_introtext ? self::truncate($item->introtext, $introtext_limit) : '';
			
			// added Angie show_unauthorizid
			if ($showReadmore) {
				$item->displayReadmore = '<a style="color: '.$linkColor.'" class="readmore" href = "' .$item->link. '" title="'.$item->title.'"> '.$altReadmore. ' </a>' ;
			}
		}
		
		return $items;
	}
	
	public static function _cleanIntrotext($introtext)
	{
		$introtext = str_replace('<p>', ' ', $introtext);
		$introtext = str_replace('</p>', ' ', $introtext);
		$introtext = strip_tags($introtext, '<a><em><strong>');
		
		$introtext = trim($introtext);
		
		return $introtext;
	}

	/**
	* This is a better truncate implementation than what we
	* currently have available in the library. In particular,
	* on index.php/Banners/Banners/site-map.html JHtml's truncate
	* method would only return "Article...". This implementation
	* was taken directly from the Stack Overflow thread referenced
	* below. It was then modified to return a string rather than
	* print out the output and made to use the relevant JString
	* methods.
	*
	* @link http://stackoverflow.com/questions/1193500/php-truncate-html-ignoring-tags
	* @param mixed $html
	* @param mixed $maxLength
	*/
	public static function truncate($html, $maxLength = 0)
	{
		$printedLength = 0;
		$position = 0;
		$tags = array();

		$output = '';

		if (empty($html)) {
			return $output;
		}

		while ($printedLength < $maxLength && preg_match('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position))
		{
			list($tag, $tagPosition) = $match[0];

			// Print text leading up to the tag.
			$str = JString::substr($html, $position, $tagPosition - $position);
			if ($printedLength + JString::strlen($str) > $maxLength) {
				$output .= JString::substr($str, 0, $maxLength - $printedLength);
				$printedLength = $maxLength;
				break;
			}

			$output .= $str;
			$lastCharacterIsOpenBracket = (JString::substr($output, -1, 1) === '<');

			if ($lastCharacterIsOpenBracket) {
				$output = JString::substr($output, 0, JString::strlen($output) - 1);
			}

			$printedLength += JString::strlen($str);

			if ($tag[0] == '&') {
				// Handle the entity.
				$output .= $tag;
				$printedLength++;
			}
			else {
				// Handle the tag.
				$tagName = $match[1][0];

				if ($tag[1] == '/') {
					// This is a closing tag.
					$openingTag = array_pop($tags);

					$output .= $tag;
				}
				else if ($tag[JString::strlen($tag) - 2] == '/') {
					// Self-closing tag.
					$output .= $tag;
				}
				else {
					// Opening tag.
					$output .= $tag;
					$tags[] = $tagName;
				}
			}

			// Continue after the tag.
			if ($lastCharacterIsOpenBracket) {
				$position = ($tagPosition - 1) + JString::strlen($tag);
			}
			else {
				$position = $tagPosition + JString::strlen($tag);
			}

		}

		// Print any remaining text.
		if ($printedLength < $maxLength && $position < JString::strlen($html)) {
			$output .= JString::substr($html, $position, $maxLength - $printedLength);
		}

		// Close any open tags.
		while (!empty($tags))
		{
			$output .= sprintf('</%s>', array_pop($tags));
		}

		$length = JString::strlen($output);
		$lastChar = JString::substr($output, ($length - 1), 1);
		$characterNumber = ord($lastChar);

		if ($characterNumber === 194) {
			$output = JString::substr($output, 0, JString::strlen($output) - 1);
		}

		$output = JString::rtrim($output);

		return $output.'&hellip;';
	}
}
?>
