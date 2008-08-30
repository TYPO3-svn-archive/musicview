<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_chart extends xmlel_base {

	/**
	 * Structure about the <chart></chart> node
	 */
	private $tagStruct = array(
		'chart' => array(
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<chart></chart>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/**
	 * Get the markers for the attributes of the xml structure.
	 *
	 * @param	string 	$name: The name of the tag upper case
	 * @return	The marker array of the attributes
	 */
	protected function getAttrMarkers($name) {
		$markerArray = parent::getAttrMarkers($name);

		$from = $this->getAttribute('from');
		$to = $this->getAttribute('to');

		$markerArray['###CHART_FROMTO###'] = $from . '-' . $to;
		$markerArray['###CHART_FROMTO_USERREADABLE###'] = strftime('%d-%m-%G', $from) . ' - ' . strftime('%d-%m-%G', $to);

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_chart.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_chart.php']);
}
?>
