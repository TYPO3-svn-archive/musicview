<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class group_getWeeklyTrackChart extends user_getWeeklyAlbumChart {
	
	/**
	 * The name of the template's subpart to fill
	 */
	protected $subTemplateName = '###TEMPLATE_TRACK###';
	/**
	 * The name of the xmlel_objects child to display
	 */
	protected $xmlelSubobjectName = 'track';
	/**
	 * The template marker's name for the class
	 */
	protected $templateMarkerChartClass = '###TEMPLATE_TRACK_group.getWeeklyTrackChart_TR_CLASS-effect###';
	/**
	 * The template marker's name for the width
	 */
	protected $templateMarkerChartWidth = '###TEMPLATE_TRACK_group.getWeeklyTrackChart_DIV_WIDTH###';
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.group_getWeeklyTrackChart.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.group_getWeeklyTrackChart.php']);
}

?>
