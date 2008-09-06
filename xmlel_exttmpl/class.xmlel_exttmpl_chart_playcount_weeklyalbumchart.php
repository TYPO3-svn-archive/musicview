<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_exttmpl_chart_playcount_weeklyalbumchart extends xmlel_exttmpl_chart_count_toptags {
	
	public function __construct() {
		parent::__construct();
		
		$this->subobjectValue = 'playcount';
		$this->parentClass = xmlel_weeklyalbumchart;
		$this->childClass = xmlel_album;
		$this->childKey = 'album';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getTopTags.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getTopTags.php']);
}
?>
