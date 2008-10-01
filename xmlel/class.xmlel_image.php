<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008 Christoph Gostner <christoph.gostner@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_image extends xmlel_base {

	/**
	 * The different image widths for small, medium and large pictures.
	 * 
	 * @var array
	 */
	protected $width;
	
	/**
	 * Structure about the <image></image> node
	 * 
	 * Template marker to set:
	 *  - ###IMAGE_CONTENT###
	 */
	private $tagStruct = array(
		'image' => array(
		),
	);

	/**
	 * Constructor.
	 * 
	 * @param DOMNode $domNode Node, should be a '<image></image>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
		
		$this->width = array(
			'small' => 50,
			'medium' => 130,
			'large' => 300,
		);
	}
	
	/**
	 * Get the content marker.
	 *
	 * @return The content marker
	 * @author Christoph Gostner
	 */
	public function getContentMarker() {
		$name = strtoupper($this->getName());
		$name = '###'.$name.'_CONTENT###';

		$markerArray = array();
		$markerArray[$name] = $this->getContent();

		return $markerArray;
	}
	
	/**
	 * Get the content of the object.
	 *
	 * @return The content of the object
	 * @author Christoph Gostner
	 */
	public function getContent() {
		$width = $this->getImageWidth();
		$content = $this->content;
		
		if (strlen($content) > 0) {
			return '<img width="' . $this->width[$width] . '" src="' . $content . '" />';
		}
		if (is_file(t3lib_extMgm::siteRelPath('musicview') . 'res/img/'. $width .'.gif')) {
			return '<img width="' . $this->width[$width] . '" src="' . t3lib_extMgm::siteRelPath('musicview') . 'res/img/'. $width .'.gif' . '" />';
		}
		
		return '<img width="' . $this->width[$width] . '" src="' . t3lib_extMgm::siteRelPath('musicview') . 'res/img/small.gif' . '" />';
	}
	
	/**
	 * The method returns the image size if it's set.
	 * It the size isn't set, it returns a 'small' as default value.
	 * 
	 * @return The image's size 
	 * @author Christoph Gostner
	 */
	protected function getImageWidth() {
		$size = $this->getAttribute('size');
		if (array_key_exists($size, $this->width)) {
			return $size;
		}
		return 'small';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_image.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_image.php']);
}

?>
