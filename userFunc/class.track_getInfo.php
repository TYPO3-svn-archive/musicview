<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class track_getInfo extends artist_getInfo {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		if (!($this->xmlel_obj instanceof xmlel_track))
			die;

		$template = $this->getTemplateParts('###TEMPLATE###', 
											array('###TEMPLATE_ARR_ARTIST###', 
													'###TEMPLATE_ALBUM###',
													'###TEMPLATE_WIKI###'));
		$artistArr = $this->xmlel_obj->getChild('artist');
		$albumArr = $this->xmlel_obj->getChild('album');
		$wikiArr = $this->xmlel_obj->getChild('wiki');
		
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray['###TEMPLATE_ARR_ARTIST###'] = $this->displayObjects($template['item0'], $artistArr);
		$subpartArray['###TEMPLATE_ALBUM###'] = $this->displayObjects($template['item1'], $albumArr);
		$subpartArray['###TEMPLATE_WIKI###'] = $this->displayObjects($template['item2'], $wikiArr);
			
		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getInfo.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getInfo.php']);
}
?>
