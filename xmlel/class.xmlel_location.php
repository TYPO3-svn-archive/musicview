<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_location extends xmlel_base {
	
	/**
	 * Structure about the <location></location> node
	 */
	private $tagStruct = array(
		'location' => array(
			array('tag' => 'geo:point', 'xmlel_class' => 'xmlel_geopoint'),
			'city',
			'country',
			'street',
			'postalcode',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param DOMNode $domNode Node, should be a '<location></location>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_location.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_location.php']);
}
?>
