<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class group_getWeeklyChartList extends user_getWeeklyChartList {

	protected static $templateFieldDate = 'weeklychartlist_date';
	protected static $templateFieldMethod = 'weeklychartlist_method';
	
	protected $lastfm_api_func = array(
			'group.getWeeklyAlbumChart', // FIXME: why the class isn't able to view the weekly album chart???
			'group.getWeeklyArtistChart',
			'group.getWeeklyTrackChart',
	);
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.group_getWeeklyChartList.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.group_getWeeklyChartList.php']);
}

?>
