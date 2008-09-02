<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class tag_getSimilar extends musicview_userfunc_base {

	/**
	 * The name of the search field
	 */
	private $input = 'tag.getSimilar-INPUT-TAGNAME';
	
	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$template = $this->getTemplateParts('###TEMPLATE###', array());
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$markerArray['###TAG_TAG.REQ_TAG###'] = $this->getTagForInput();
		$tmplMarkerArray = $this->tx_musicview_pi1->getTemplateMarker();

		return $this->substituteMarkerArrayCached($template['total'], array_merge($markerArray, $tmplMarkerArray));
	}
	
	/**
	 * TODO:
	 * Get the value for the search field.
	 * 
	 * @return 	The value for the search field
	 */
	private function getTagForInput() {
		return 'bla';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']);
}
?>
