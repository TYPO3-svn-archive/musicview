<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class track_getSimilar extends tag_getSimilar {
	
	/**
	 * The child key for the items to display
	 */
	protected $childKey = 'track';
	/**
	 * The name of the subpart in the template file
	 */
	protected $templateSubpartName = '###TEMPLATE_TRACK###';

	/**
	 * Fill the template with the objects
	 *
	 * @param	mixed	$template: The template to fill
	 * @param	array	$objectArr: The object to fill in the template
	 * @return	The filled template
	 */
	protected function displayTags($template, $objectArr) {
		$tmpl = $this->getSubTemplate($template, '###TEMPLATE_ARTIST###');
		$content = '';

		foreach ($objectArr as $object) {
			$markerArray = $object->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$subpartArray['###TEMPLATE_ARTIST###'] = $this->displayArtist($tmpl, $object->getChild('artist'));
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		return $content;
	}
	
	/**
	 * Fill the template with artist information.
	 * 
	 * @param 	mixed	$template: The template to use
	 * @param 	array	$artists: The artists to fill in
	 * @return 	The filled template
	 */
	protected function displayArtist($template, $artists) {
		$content = '';
		
		foreach ($artists as $object) {
			$markerArray = $object->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']);
}
?>
