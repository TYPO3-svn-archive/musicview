<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_artist extends xmlel_base {

	/**
	 * Structure about the <artist></artist> node
	 */
	private $tagStruct = array(
		'artist' => array(
			array('tag' => 'image'),
			array('tag' => 'stats'),
			array('tag' => 'bio'),
			array('tag' => 'similar'),
			'name',
			'mbid',
			'playcount',
			'tagcount',
			'url',
			'tagcount',
			'streamable',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<artist></artist>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/** 
	 * Costum template markers.
	 *
	 * @param       object  $cObj: Content object
	 * @param       array   $conf: The configuration
	 * @return      Marker array
	 */
	public function getTemplateMarkers($cObj, $conf) {
		$markerArray = parent::getTemplateMarkers($cObj, $conf);
		$markerArray['###ARTIST_URLNAME###'] = $this->getUrlName($cObj, $conf);
		$markerArray['###ARTIST_IMAGE###'] = $this->filterImage($conf);	

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_artist.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_artist.php']);
}
?>
