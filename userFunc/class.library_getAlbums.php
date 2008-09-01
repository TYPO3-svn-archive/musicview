<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class library_getAlbums extends user_getTopAlbums {
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.library_getAlbums.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.library_getAlbums.php']);
}

?>