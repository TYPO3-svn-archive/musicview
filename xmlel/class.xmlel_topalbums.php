<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_topalbums extends xmlel_base {

	/**
	 * Structure about the <topalbums></topalbums> node
	 */
	private $tagStruct = array(
		'topalbums' => array(
			array('tag' => 'album'),
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<topalbums></topalbums>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_topalbums.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_topalbums.php']);
}
?>
