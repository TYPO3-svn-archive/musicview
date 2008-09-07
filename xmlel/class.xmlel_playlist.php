<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_playlist extends xmlel_base {

	/**
	 * Structure about the <playlist></playlist> node
	 */
	private $tagStruct = array(
		'playlist' => array(
			array('tag' => 'trackList'),
			'id',
			'title',
			'annotation',
			'date',
			'size',
			'creator',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<playlist></playlist>' node
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
		$markerArray = parent::getTemplateMarkers($cObj, $conf);
 
		$typolink_conf['parameter'] = $this->getValue('creator');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###PLAYLIST_CREATOR###'] = $cObj->typolink($this->getValue('creator'), $typolink_conf);
		
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_playlist.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_playlist.php']);
}
?>
