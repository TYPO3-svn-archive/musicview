<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getLovedTracks extends musicview_userfunc_base {

	/**
	 * The name of the template's subpart to fill
	 */
	protected $subTemplateName = '###TEMPLATE_TRACK###';
	/**
	 * The name of the xmlel_objects child to display
	 */
	protected $xmlelSubobjectName = 'track';

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$content = '';
		$template = $this->getTemplateParts('###TEMPLATE###', array($this->subTemplateName));
		$objects = $this->xmlel_obj->getChild($this->xmlelSubobjectName);

		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray[$this->subTemplateName] = $this->displaySubpart($template['item0'], $objects);

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	/** 
	 * Get the content for the top artists
	 *
	 * @param 	mixed 	$template: The template to use
	 * @param	array	$tracks: The albums to display
	 */
	protected function displaySubpart($template, $tracks) {
		$content = '';

		foreach ($tracks as $track) {
			$markerArray = $track->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}

		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getLovedTracks.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getLovedTracks.php']);
}

?>
