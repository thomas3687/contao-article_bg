<?php

class tl_article_bg extends tl_article
{
	
	/**
	 * Return the file picker wizard
	 * @param \DataContainer
	 * @return string
	 */
	public function filePicker(DataContainer $dc)
	{
		return ' <a href="contao/file.php?do='.Input::get('do').'&amp;table='.$dc->table.'&amp;field='.$dc->field.'&amp;value='.$dc->value.'" title="'.specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MSC']['filepicker'])).'" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\''.specialchars($GLOBALS['TL_LANG']['MOD']['files'][0]).'\',\'url\':this.href,\'id\':\''.$dc->field.'\',\'tag\':\'ctrl_'.$dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '').'\',\'self\':this});return false">' . Image::getHtml('pickfile.gif', $GLOBALS['TL_LANG']['MSC']['filepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}
	/*
	public function removeArticle($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
		$arrContentElements = $this->Database->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
			->execute($dc->id)->fetchEach('id');
		foreach ($arrContentElements as $cte_id)
		{
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_content', $cte_id);
		}
	}

	public function removePage($dc)
	{
		// remove tags of all articles in the page
		$arrArticles = $this->Database->prepare("SELECT DISTINCT id FROM tl_article WHERE pid = ?")
			->execute($dc->id)->fetchEach('id');
		foreach ($arrArticles as $id)
		{
			$arrContentElements = $this->Database->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
				->execute($id)->fetchEach('id');
			foreach ($arrContentElements as $cte_id)
			{
				$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
					->execute('tl_content', $cte_id);
			}
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_article', $id);
		}
	}

	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_article_copy')))
		{
			foreach ($this->Session->get('tl_article_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_article_copy', null);
		if (\Input::get('act') != 'copy')
		{
			return;
		}
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")
			->execute(\Input::get('id'), $dc->table);
		$tags = array();
		while ($objTags->next())
		{
			array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		$this->Session->set("tl_article_copy", $tags);
	}
	*/
}


/**
 * Change tl_article default palette
 */

$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_article', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace("space", "space;{atricle_bg_layout},layout_full_width;{atricle_bg_legend},background_image,background_position, background_repeat, background_blur_radius, background_color", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
	//$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'tags_showtags';
	//$GLOBALS['TL_DCA']['tl_article']['subpalettes']['tags_showtags']    = 'tags_max_tags,tags_relevance,tags_jumpto';
	//$GLOBALS['TL_DCA']['tl_article']['config']['ondelete_callback'][] = array('tl_article_tags', 'removeArticle');
	//$GLOBALS['TL_DCA']['tl_page']['config']['ondelete_callback'][] = array('tl_article_tags', 'removePage');
	//$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][] = array('tl_article_tags', 'onCopy');
}


$GLOBALS['TL_DCA']['tl_article']['fields']['layout_full_width'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['layout_full_width'],
	'inputType'               => 'checkbox',
	'default'                => false, 
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['background_image'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['background_image'],
	'inputType'               => 'text',
	'eval'                    => array('filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'fieldType'=>'radio', 'tl_class'=>'w50 wizard'),
	'wizard' => array
			(
				array('tl_article_bg', 'filePicker')
			),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['background_position'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['background_position'],
	'inputType'               => 'select',
	'options'                 => array('left top', 'left center', 'left bottom', 'center top', 'center center', 'center bottom', 'right top', 'right center', 'right bottom'),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['background_repeat'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['background_repeat'],
	'inputType'               => 'select',
	'options'                 => array('repeat', 'repeat-x', 'repeat-y', 'no-repeat'),
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['background_color'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['background_color'],
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['background_blur_radius'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['background_blur_radius'],
	'inputType'               => 'inputUnit',
	'options'                 => array('px', '%', 'em', 'rem', 'ex', 'pt', 'pc', 'in', 'cm', 'mm'),
	'eval'                    => array('includeBlankOption'=>true, 'rgxp'=>'digit_auto_inherit', 'maxlength' => 20, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

