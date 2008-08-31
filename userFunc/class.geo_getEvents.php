<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class geo_getEvents extends musicview_userfunc_base {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_EVENT###', '###TEMPLATE_VENUE###'));
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		
		$eventsArr = $this->xmlel_obj->getChild('event');
		$subpartArray['###TEMPLATE_EVENT###'] = $this->displayEvents($template['item0'], $eventsArr);

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}
	
	/**
	 * Fill the event part of the template.
	 * 
	 * @param	mixed	$template: The template to use
	 * @param	array	$eventsArr: The array to display
	 * @return	The template's content
	 */
	protected function displayEvents($template, $eventsArr) {
		$artistsTemplate = $this->getSubTemplate($template, '###TEMPLATE_ARTISTS###');
		$venueTemplate = $this->getSubTemplate($template, '###TEMPLATE_VENUE###');
		$content = '';
		
		foreach ($eventsArr as $event) {
			$artists = $event->getChild('artists');
			$venueArr = $event->getChild('venue');
			
			$markerArray = $event->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$subpartArray['###TEMPLATE_ARTISTS###'] = $this->displayArtists($artistsTemplate, $artists);
			$subpartArray['###TEMPLATE_VENUE###'] = $this->displayVenue($venueTemplate, $venueArr);
			
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		return $content;
	}
	
	/**
	 * Fill the artists part of the template.
	 * 
	 * @param	mixed	$template: The template to use
	 * @param	array	$artists: The array to display
	 * @return	The template's content
	 */
	protected function displayArtists($template, $artists) {
		$artistTemplate = $this->getSubTemplate($template, '###TEMPLATE_ARTIST###');
		$content = '';
		
		foreach ($artists as $a) {
			$artistArr = $a->getChild('artist');
			$markerArray = $a->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$subpartArray['###TEMPLATE_ARTIST###'] = $this->displayArtist($artistTemplate, $artistArr);
			
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		
		return $content;
	}
	
	/**
	 * Fill the artist part of the template.
	 * 
	 * @param	mixed	$template: The template to use
	 * @param	array	$artistArr: The array to display
	 * @return	The template's content
	 */
	protected function displayArtist($template, $artistArr) {
		$content = '';
		foreach ($artistArr as $artist) {
			$markerArray = $artist->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		return $content;
	}
	
	/**
	 * Fill the venue part of the template.
	 * 
	 * @param	mixed	$template: The template to use
	 * @param	array	$venueArr: The array to display
	 * @return	The template's content
	 */
	protected function displayVenue($template, $venueArr) {
		$content = '';
		$locationTemplate = $this->getSubTemplate($template, '###TEMPLATE_LOCATION###');
		 
		foreach ($venueArr as $venue) {
			$locationArr = $venue->getChild('location');
			
			$markerArray = $venue->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$subpartArray['###TEMPLATE_LOCATION###'] = $this->displayLocation($locationTemplate, $locationArr);
			
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		return $content;
	}
	
	/**
	 * Fill the location part of the template.
	 * 
	 * @param	mixed	$template: The template to use
	 * @param	array	$locationArr: The array to display
	 * @return	The template's content
	 */
	protected function displayLocation($template, $locationArr) {
		$content = '';
		
		foreach ($locationArr as $location) {
			$markerArray = $location->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.geo_getEvents.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.geo_getEvents.php']);
}

?>