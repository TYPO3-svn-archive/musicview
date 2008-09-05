<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_wiki extends xmlel_base {

	/**
	 * Structure about the <track></track> node
	 */
	private $tagStruct = array(
		'wiki' => array(
			'published',
			'summary',
			'content',
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
		
		$markerArray['###WIKI_CONTENT###'] = str_replace("\n", "<br />\n", $this->getValue('content'));
		
		return $markerArray;
	}

	/**
	 * Get the content marker.
	 *
	 * @return 	The content marker
	 */
	public function getContentMarker() {
		$name = strtoupper($this->getName());
		$name = '###'.$name.'_ALL_CONTENT###';

		return array($name => $this->getContent());
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_track.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_track.php']);
}
?>
