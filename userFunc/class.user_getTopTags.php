<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getTopTags extends user_getWeeklyAlbumChart {

	/**
	 * The name of the template's subpart to fill
	 */
	protected $subTemplateName = '###TEMPLATE_TAG###';
	/**
	 * The name of the xmlel_objects child to display
	 */
	protected $xmlelSubobjectName = 'tag';
	/**
	 * The template marker's name for the class
	 */
	protected $templateMarkerChartClass = '###TEMPLATE_TAG_user.getTopTags_TR_CLASS-effect###';
	/**
	 * The template marker's name for the width
	 */
	protected $templateMarkerChartWidth = '###TEMPLATE_TAG_user.getTopTags_DIV_WIDTH###';
	/**
	 * The property to filter the width
	 */
	protected $subobjectValue = 'count';
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getTopTags.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getTopTags.php']);
}

?>
