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
class xmlel_track extends xmlel_base {

	/**
	 * Structure about the <track></track> node
	 */
	private $tagStruct = array(
		'track' => array(
			array('tag' => 'artist'),
			array('tag' => 'album'),
			array('tag' => 'image'),
			array('tag' => 'toptags'),
			array('tag' => 'wiki'),
			'id',
			'name',
			'title',
			'identifier',
			'streamable',
			'playcount',
			'tagcount',
			'duration',
			'listeners',
			'creator',
			'mbid',
			'match',
			'info',
			'url',
			'date',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<track></track>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/** 
	 * Costum template markers.
	 *
	 * @param       object  $cObj: Content object
	 * @param       array   $conf: The event configuration
	 * @return      Marker array
	 */
	public function getTemplateMarkers($cObj, $conf) {
		$markerArray = parent::getTemplateMarkers();

		$markerArray['###TRACK_IMAGE###'] = $this->filterImage($cObj, $conf);

		$ar = array();
		$artists = $this->getChild('artist');
		foreach ($artists as $artist) {
			$url = $artist->getValue('url');
			if (is_null($url) || strlen($url) == 0) {
				array_push($ar, $artist->getContent());
			} else {
				array_push($ar, $artist->getUrlName($cObj, $conf));
			}
		}
		$markerArray['###TRACK_ARTISTS###'] = implode(',', $ar);
		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###TRACK_URLNAME###'] = $cObj->typolink($this->getValue('name'), $typolink_conf);
		$markerArray['###TRACK_URLTITLE###'] = $cObj->typolink($this->getValue('title'), $typolink_conf);

		$typolink_conf['parameter'] = $this->getValue('info');
		$markerArray['###TRACK_INFOTITLE###'] = $cObj->typolink($this->getValue('title'), $typolink_conf);
		
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_track.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_track.php']);
}
?>
