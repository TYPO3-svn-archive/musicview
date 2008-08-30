<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_tag extends xmlel_base {

	/**
	 * Structure about the <tag></playlist> node
	 */
	private $tagStruct = array(
		'tag' => array(
			'name',
			'count',
			'url',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<tag></playlist>' node
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
		$markerArray['###TAG_URLNAME###'] = $this->getUrlName($cObj, $conf);

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_tag.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_tag.php']);
}
?>
