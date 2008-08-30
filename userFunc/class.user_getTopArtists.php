<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getTopArtists extends user_getLovedTracks {

	/**
	 * The name of the template's subpart to fill
	 */
	protected $subTemplateName = '###TEMPLATE_ARTIST###';
	/**
	 * The name of the xmlel_objects child to display
	 */
	protected $xmlelSubobjectName = 'artist';
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getTopArtists.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getTopArtists.php']);
}

?>
