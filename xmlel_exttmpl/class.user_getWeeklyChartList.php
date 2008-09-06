<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getWeeklyChartList extends group_getWeeklyChartList {
	
	protected $lastfm_api_func = array(
			'user.getWeeklyAlbumChart',
			'user.getWeeklyArtistChart',
			'user.getWeeklyTrackChart',
	);
	
	protected static $templateFieldDate = 'weeklychartlist_date';
	protected static $templateFieldMethod = 'weeklychartlist_method';
	
	public function __construct() {
		parent::__construct();
		
		$this->tagStruct = array(
			'chart' => array(
				'###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE###',
				'###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD###',
			),
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyChartList.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyChartList.php']);
}
?>
