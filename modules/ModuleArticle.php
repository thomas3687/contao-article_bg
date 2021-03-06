<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Core
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace AurealisBG;


/**
 * Class ModuleArticle
 *
 * Provides methodes to handle articles.
 * @copyright  Helmut Schottmüller 2012
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Tags
 */
class ModuleArticle extends \Contao\ModuleArticle
{
	
	
 static function hex2rgb($hex) {
   
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
	
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_article_bg';

	/**
	 * Generate the module
	 */
	protected function compile()
	{
			
		\Contao\ModuleArticle::compile();
		
		//HINTERGRUNDFARBE
		
		
		if(strlen($this->background_color)>0){
		$bg_color = deserialize($this->background_color);
		
		$rgb = ModuleArticle::hex2rgb($bg_color[0]);
		if($bg_color[1] < 100 && strlen($bg_color[1])>0){
		$this->Template->background_color = "background-color: #".$bg_color[0]."; background-color: rgba(".$rgb['0'].", ".$rgb['1'].", ".$rgb['2'].", 0.".$bg_color[1]." ); ";
		}else if(strlen($bg_color[0])>0){
		$this->Template->background_color = "background-color: #".$bg_color[0]."; "; 	
			}else{
			$this->Template->background_color = null;	
				}
		
		}
		
		$this->Template->layout_full_width = $this->layout_full_width;
		
	/*	$this->Template->show_tags = $this->tags_showtags;
		if ($this->tags_showtags)
		{
			$this->Template->tags = $this->getTagsForArticle($this->tags_max_tags, $this->tags_relevance, $this->tags_jumpto);
		}
		
		*/
	}
	
	

	
	
	
/*
	public function sortByRelevance($a, $b)
	{
		if ($a['tagcount'] == $b['tagcount']) 
		{
			return 0;
		}
		return ($a['tagcount'] < $b['tagcount']) ? 1 : -1;
	} 

	private function getTagsForArticle($max_tags = 0, $relevance = 0, $target = 0)
	{
		$table = 'tl_article';
		$id = $this->id;
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ? ORDER BY tag ASC")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		if (count($arrTags))
		{
			if ($max_tags > 0)
			{
				$arrTags = array_slice($arrTags,0,$max_tags);
			}
			$arrTagsWithCount = $this->Database->prepare("SELECT tag, COUNT(tag) as tagcount FROM tl_tag WHERE from_table = ? GROUP BY tag ORDER BY tag ASC")
				->execute($table)
				->fetchAllAssoc();
			$countarray = array();
			foreach ($arrTagsWithCount as $data)
			{
				$countarray[$data['tag']] = $data['tagcount'];
			}
			foreach ($arrTags as $idx => $tag)
			{
				$arrTags[$idx]['tagcount'] = $countarray[$tag['tag']];
				$arrTags[$idx]['tag_class'] = \Contao\TagList::_getTagNameClass($tag['tag']);
			}
			if ($relevance == 1)
			{
				usort($arrTags, array($this, 'sortByRelevance'));
			}
			if (strlen($target))
			{
				$pageArr = array();
				$objFoundPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=? OR alias=?")
					->limit(1)
					->execute(array($target, $target));
				$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
				if (count($pageArr))
				{
					foreach ($arrTags as $idx => $tag)
					{
						$arrTags[$idx]['url'] = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . $tag['tag']));
					}
				}
			}
		}
		return $arrTags;
	}
	*/
}
