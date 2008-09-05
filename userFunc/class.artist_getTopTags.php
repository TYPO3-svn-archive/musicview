<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class artist_getTopTags extends user_getTopTags {

	/**
	 * The template marker's name for the class
	 */
	protected $templateMarkerChartClass = '###TEMPLATE_TAG_artist.getTopTags_TR_CLASS-effect###';
	/**
	 * The template marker's name for the width
	 */
	protected $templateMarkerChartWidth = '###TEMPLATE_TAG_artist.getTopTags_DIV_WIDTH###';
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getTopTags.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getTopTags.php']);
}
?>
