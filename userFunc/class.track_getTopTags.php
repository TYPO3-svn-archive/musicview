<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class track_getTopTags extends tag_getSimilar {
	
	/**
	 * The child key for the items to display
	 */
	protected $childKey = 'tag';
	/**
	 * The name of the subpart in the template file
	 */
	protected $templateSubpartName = '###TEMPLATE_TAG###';
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.track_getTopTags.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.track_getTopTags.php']);
}
?>
