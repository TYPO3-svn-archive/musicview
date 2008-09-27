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
class xmlel_lfm extends xmlel_base {

	/**
	 * Main <lfm></lfm> tag for the xml structure
	 */
	const XMLEL_NAME = 'lfm';
	/**
	 * Name of the <lfm></lfm> attribute that defines the status of the response
	 */
	const XMLEL_STATUS_ATTR = 'status';
	/**
	 * Positive response message
	 */
	const XMLEL_STATUS_ATTR_VALUE_OK = 'ok';

	private $tagStruct = array(
		'lfm' => array(
			array('tag' => 'album'),
			array('tag' => 'albums'),
			array('tag' => 'artist'),
			array('tag' => 'artists'),
			array('tag' => 'comparison'),
			array('tag' => 'error'), /* error class -> status != ok */
			array('tag' => 'event'),
			array('tag' => 'events'),
			array('tag' => 'friends'),
			array('tag' => 'lovedtracks'),
			array('tag' => 'neighbours'),
			array('tag' => 'playlist'),
			array('tag' => 'playlists'),
			array('tag' => 'recenttracks'),
			array('tag' => 'results'),
			array('tag' => 'similarartists'),
			array('tag' => 'similartags'),
			array('tag' => 'similartracks'),
			array('tag' => 'topalbums'),
			array('tag' => 'topartists'),
			array('tag' => 'topfans'),
			array('tag' => 'toptags'),
			array('tag' => 'toptracks'),
			array('tag' => 'track'),
			array('tag' => 'tracks'),
			array('tag' => 'weeklyalbumchart'),
			array('tag' => 'weeklyartistchart'),
			array('tag' => 'weeklychartlist'),
			array('tag' => 'weeklytrackchart'),
		),
	);

	/**
	 * Constructor that initialises the children's array.
	 */
	protected function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/** 
	 * Go throw the xml structure and add content elements and sub elements to the
	 * internal memory.
	 *
	 * @param DOMNode $dom The DOMNodeList that contains the sub content.
	 * @return The generated 'xmlel_lfm' object with the content
	 */
	public static function lfmFactory($dom) {
		/*DOMNode*/$dNode = $dom->item(0);
		$xmlel_lfm = new xmlel_lfm($dNode);

		return $xmlel_lfm;
	}

	/**
	 * Check the status of the xml response.
	 * If the status is OK the method returns true, in any other case false.
	 * 
	 * @return	The status of the xml response
	 */
	public function checkStatus() {
		$status = $this->getAttribute(self::XMLEL_STATUS_ATTR);
		if (!is_null($status) && $status == self::XMLEL_STATUS_ATTR_VALUE_OK) {
			return true;
		}
		return false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_lfm.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_lfm.php']);
}

?>
