<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_extension extends xmlel_base {

	/**
	 * Structure about the <playlist></playlist> node
	 */
	private $tagStruct = array(
		'extension' => array(
			'artistpage',
			'albumpage',
			'trackpage',
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
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_extension.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_extension.php']);
}
?>