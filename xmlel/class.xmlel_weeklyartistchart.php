<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_weeklyartistchart extends xmlel_base {

	/**
	 * Structure about the <weeklyartistchart></weeklyartistchart> node
	 */
	private $tagStruct = array(
		'weeklyartistchart' => array(
			array('tag' => 'artist'),
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<weeklyartistchart></weeklyartistchart>' node
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

		if (array_key_exists('###WEEKLYARTISTCHART_ATTR_FROM###', $markerArray)) {
			$v = $markerArray['###WEEKLYARTISTCHART_ATTR_FROM###'];
			$markerArray['###WEEKLYARTISTCHART_ATTR_FROM###'] = strftime('%d-%m-%G', $v); 
		}

		if (array_key_exists('###WEEKLYARTISTCHART_ATTR_TO###', $markerArray)) {
			$v = $markerArray['###WEEKLYARTISTCHART_ATTR_TO###'];
			$markerArray['###WEEKLYARTISTCHART_ATTR_TO###'] = strftime('%d-%m-%G', $v); 
		}
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_weeklyartistchart.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_weeklyartistchart.php']);
}
?>
