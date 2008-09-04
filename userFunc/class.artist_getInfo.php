<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class artist_getInfo extends user_getEvents {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		if (!($this->xmlel_obj instanceof xmlel_artist))
			die;
			
		$content = '';
		$bioArr = $this->xmlel_obj->getChild('bio');
		$similarArr = $this->xmlel_obj->getChild('similar');
		$statsArr = $this->xmlel_obj->getChild('stats');
		
		$template = $this->getTemplateParts('###TEMPLATE###', 
							array('###TEMPLATE_BIO-SUMMARY###', 
									'###TEMPLATE_BIO-CONTENT###',
									'###TEMPLATE_SIMILAR###',
									'###TEMPLATE_STATS###' ));
				
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray['###TEMPLATE_BIO-SUMMARY###'] = $this->displayBioSummary($template['item0'], $bioArr);
		$subpartArray['###TEMPLATE_BIO-CONTENT###'] = $this->displayBioSummary($template['item1'], $bioArr);
		$subpartArray['###TEMPLATE_SIMILAR###'] = $this->displaySimilar($template['item2'], $similarArr);
		$subpartArray['###TEMPLATE_STATS###'] = $this->displayStats($template['item3'], $statsArr);
		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}
	
	/**
	 * Fill the template with objects.
	 * 
	 * @param 	array	$bioArr: The objects to fill in
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled template
	 */
	protected function displayBioSummary($template, $bioArr) {
		$content = '';
		
		foreach ($bioArr as $bio) {
			$markerArray = $bio->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		
		return $content;
	}
	
	/**
	 * Fill the template with objects.
	 * 
	 * @param 	array	$similarArr: The objects to fill in
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled template
	 */
	protected function displaySimilar($template, $similarArr) {
		$tmpl = $this->getSubTemplate($template, '###TEMPLATE_ARTIST###');
		$content = '';
		
		foreach ($similarArr as $similar) {
			$artistArr = $similar->getChild('artist');
			
			$markerArray = $similar->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$subpartArray['###TEMPLATE_ARTIST###'] = $this->displayArtists($tmpl, $similar->getChild('artist'));
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		
		return $content;
	}
	
	/**
	 * Fill the template with objects.
	 * 
	 * @param 	array	$artistArr: The objects to fill in
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled template
	 */
	protected function displayArtists($template, $artistArr) {
		$content = '';
	
		foreach ($artistArr as $artist) {
			$markerArray = $artist->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		
		return $content;
	}
	
	/**
	 * Fill the template with objects.
	 * 
	 * @param 	array	$statsArr: The objects to fill in
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled template
	 */
	protected function displayStats($template, $statsArr) {
		$content = '';
		
		foreach ($statsArr as $stats) {
			$markerArray = $stats->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getInfo.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.artist_getInfo.php']);
}
?>
