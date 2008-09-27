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
class xmlel_weeklytrackchart extends xmlel_base {

	/**
	 * Structure about the <weeklytrackchart></weeklytrackchart> node
	 */
	private $tagStruct = array(
		'weeklytrackchart' => array(
			array('tag' => 'track'),
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<weeklytrackchart></weeklytrackchart>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/**
	 * Get the markers for the attributes of the xml structure.
	 *
	 * @param       string  $name: The name of the tag upper case
	 * @return      The marker array of the attributes
	 */
	protected function getAttrMarkers($name) {
		$markerArray = parent::getAttrMarkers($name);

		if (array_key_exists('###WEEKLYTRACKCHART_ATTR_FROM###', $markerArray)) {
			$v = $markerArray['###WEEKLYTRACKCHART_ATTR_FROM###'];
			$markerArray['###WEEKLYTRACKCHART_ATTR_FROM###'] = strftime('%d-%m-%G', $v); 
		}

		if (array_key_exists('###WEEKLYTRACKCHART_ATTR_TO###', $markerArray)) {
			$v = $markerArray['###WEEKLYTRACKCHART_ATTR_TO###'];
			$markerArray['###WEEKLYTRACKCHART_ATTR_TO###'] = strftime('%d-%m-%G', $v); 
		}
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_weeklytrackchart.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_weeklytrackchart.php']);
}
?>
