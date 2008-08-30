<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getEvents extends musicview_userfunc_base {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$content = '';
		$childKeys = $this->xmlel_obj->getChildKeys();
		foreach ($childKeys as $childKey) {
			$childObjArr = $this->xmlel_obj->getChild($childKey);

			foreach ($childObjArr as $obj) {
				$content .= $this->displayEventContent($obj);
			}
		}
		return $content;
	}

	/**
	 * Get the markers from the event object and from the template and combine it with the template.
	 * The subparts have their own methods to fill their content.
	 *
	 * @param	object 	$obj: The xmlel_event object
	 * @return 	The filled content
	 */
	private function displayEventContent($obj) {
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_VENUE###', '###TEMPLATE_ARTISTS###'));
		$eventMarkers = $obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$tmplMarkers = $this->tx_musicview_pi1->getTemplateMarker();

		$subpartArray = array('###TEMPLATE_VENUE###' => '', '###TEMPLATE_ARTISTS###' => '');
		$childKeys = $obj->getChildKeys();
		foreach ($childKeys as $child) {
			switch ($child) {
				case 'venue':
					$venueArr = $obj->getChild($child);
					$subpartArray['###TEMPLATE_VENUE###'] = $this->displayVenueContent($venueArr, $template['item0']);
					break;
				case 'artists':
					$artistsArr = $obj->getChild($child);
					$subpartArray['###TEMPLATE_ARTISTS###'] = $this->displayArtistsContent($artistsArr, $template['item1']);
					break;
				default:
					break;
			}
		}

		return $this->substituteMarkerArrayCached($template['total'], array_merge($eventMarkers, $tmplMarkers), $subpartArray);
	}

	/**
	 * Fill the artists part of the template.
	 *
	 * @param	array 	$artistsArr: The artists' array
	 * @param	mixed	$template: The template to use
	 * @return	The content of the artists part
	 */
	private function displayArtistsContent($artistsArr, $template) {
		$content = '';
		$sTemplate = $this->getSubTemplate($template, '###TEMPLATE_ARTIST###');
		$tmplMarker = $this->tx_musicview_pi1->getTemplateMarker();

		foreach ($artistsArr as $artists) {
			$markerArray = $artists->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$artist = $artists->getChild('artist');
			$subpartArray['###TEMPLATE_ARTIST###'] = $this->displayArtistContent($artist, $sTemplate);

			$content .= $this->substituteMarkerArrayCached($template, array_merge($markerArray, $tmplMarker), $subpartArray);
		}
		return $content;
	}

	/**
	 * Fill the artist part of the template.
	 *
	 * @param 	array	$artistArr: The array with xmlel_artists objects
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled subpart template
	 */
	private function displayArtistContent($artistArr, $template) {
		$content = '';

		foreach ($artistArr as $artist) {
			$markerArray = $artist->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .=  $this->substituteMarkerArrayCached($template, $markerArray);
		}
		return $content;
	}

	/**
	 * Fill the venue part of the template.
	 *
	 * @param 	array	$venueArr: The array with xmlel_venue objects
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled subpart template
	 */
	private function displayVenueContent($venueArr, $template) {
		$tmpl['total'] = $template;
		$tmpl['item0'] = $this->getSubTemplate($tmpl['total'], '###TEMPLATE_LOCATION###');
		$content = '';

		foreach ($venueArr as $venue) {
			$venueMarkers = $venue->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);

			$subpartArray['###TEMPLATE_LOCATION###'] = $this->displayLocationContent($venue->getChild('location'), $tmpl['item0']);
			$content .= $this->substituteMarkerArrayCached($template, $venueMarkers, $subpartArray);
		}
		return $content;
	}

	/**
	 * Fill the location part of the template.
	 *
	 * @param 	array	$locationArr: The array with xmlel_location objects
	 * @param	mixed	$template: The template to fill
	 * @return 	The filled subpart template
	 */
	private function displayLocationContent($locationArr, $template) {
		$content = '';
		foreach ($locationArr as $location) {
			$locationMarkers = $location->getTemplateMarkers();
			$content .= $this->substituteMarkerArrayCached($template, $locationMarkers);
		}
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getEvents.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getEvents.php']);
}
?>
