<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_venue extends xmlel_base {
	
	/**
	 * Structure about the <venue></venue> node
	 */
	private $tagStruct = array(
		'venue' => array(
			array('tag' => 'location', 'xmlel_class' => 'xmlel_location'),
			'name',
			'url',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param DOMNode $domNode Node, should be a '<venue></venue>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}
	
	/** 
	 * Costum template markers.
	 *
	 * @param 	object	$cObj: Content object
	 * @return	Marker array
	 */
	public function getTemplateMarkers($cObj, $conf) {
		$markerArray = parent::getTemplateMarkers();
		
		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###VENUE_URLNAME###'] = $cObj->typolink($this->getValue('name'), $typolink_conf); 
		
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_venue.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_venue.php']);
}
?>
