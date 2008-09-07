<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class artist_getInfo extends xmlel_exttmpl {
	
	public function __construct() {
		parent::__construct();
		
		$this->tagStruct = array(
			'bio' => array(
				'###TEMPLATE_BIO_CONTENT###',
			),
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.artist_getInfo.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.artist_getInfo.php']);
}
?>
