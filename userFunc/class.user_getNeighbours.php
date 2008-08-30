<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getNeighbours extends musicview_userfunc_base {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$content = '';
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_USER###'));

		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);

		$subpartArray['###TEMPLATE_USER###'] = $this->displayUsers($template['item0'], $this->xmlel_obj->getChild('user'));

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	/**
	 * Display the selected items.
	 *
	 * @param	mixed	$template: The template to fill
	 * @param	array	$users: The array to display
	 * @return	The filled elements in the template
	 */
	private function displayUsers($template, $users) {
		
		foreach ($users as $user) {

			$markerArray = $user->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);

			$content .=  $this->substituteMarkerArrayCached($template, $markerArray);

		}
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getNeighbours.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getNeighbours.php']);
}

?>
