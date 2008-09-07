<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_exttmpl_chart_match_neighbours extends xmlel_exttmpl_chart_count_toptags {
	
	public function __construct() {
		parent::__construct();
		
		$this->subobjectValue = 'match';
		$this->parentClass = xmlel_neighbours;
		$this->childClass = xmlel_user;
		$this->childKey = 'user';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl_chart_match_neighbours.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl_chart_match_neighbours.php']);
}
?>
