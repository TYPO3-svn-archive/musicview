<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_image extends xmlel_base {

	/**
	 * Structure about the <image></image> node
	 * 
	 * Template marker to set:
	 *  - ###IMAGE_CONTENT###
	 */
	private $tagStruct = array(
		'image' => array(
		),
	);

	/**
	 * Constructor.
	 * 
	 * @param DOMNode $domNode Node, should be a '<image></image>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_image.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_image.php']);
}

?>
