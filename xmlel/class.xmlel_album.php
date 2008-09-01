<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_album extends xmlel_base {

	/**
	 * Structure about the <album></album> node
	 */
	private $tagStruct = array(
		'album' => array(
			array('tag' => 'artist'),
			array('tag' => 'image'),
			'name',
			'mbid',
			'playcount',
			'url',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<album></album>' node
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
 
		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###ALBUM_URLNAME###'] = $cObj->typolink($this->getValue('name'), $typolink_conf);

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
		$markerArray['###ALBUM_ARTISTS###'] = implode(',', $ar);
		$markerArray['###ALBUM_IMAGE###'] = $this->filterImage($conf);

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_album.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_album.php']);
}
?>
