<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getFriends extends musicview_userfunc_base {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$content = '';
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_USER###'));

		if ($this->xmlel_obj->cKeyExists('user')) {
			$users = $this->xmlel_obj->getChild('user');
			if (isset($this->conf['random']) && $this->conf['random']) {
				$limit = count($array);
				if (isset($this->conf['limit'])) {
					$limit = $this->conf['limit'];
				}
				$users = $this->randomize($users, $limit);
			}
			$content .= $this->displayUser($users, $template['item0']);
		}
		$subpartArray['###TEMPLATE_USER###'] = $content;
		return $this->substituteMarkerArrayCached($template['total'], array(), $subpartArray);
	}

	/**
	 * Fill the template for the users.
	 *
	 * @param 	array	$users: The array of users
	 * @param	mixed	$template: The template to fill
	 * @return	The content of the users
	 */
	private function displayUser($users, $template) {
		$subTemplate = $this->getSubTemplate($template, '###TEMPLATE_RECENTTRACK###');
		$content = '';
		foreach ($users as $user) {
			$markerArray = $user->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);

			$subpartArray['###TEMPLATE_RECENTTRACK###'] = $this->displayRecentTrack($user, $subTemplate);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		}
		return $content;
	}

	/**
	 * Fill the recent track if requested.
	 *
	 * @param	object	$user: The current object to display
	 * @param	mixed	$template: The template to fill
	 * @return	The content of the recent track item if requested
	 */
	private function displayRecentTrack($user, $template) {
		if ($user->cKeyExists('recenttrack')) {
			$recentTrackArr = $user->getChild('recenttrack');
			if (count($recentTrackArr) == 1) {
				$recentTrack = $recentTrackArr[0];
				
				if ($recentTrack->cKeyExists('artist')) {
					$artistArr = $recentTrack->getChild('artist');
					if (count($artistArr) == 1 ) {
						$artist = $artistArr[0];

						$aMarkerArr = $artist->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
						$rtMarkerArr = $recentTrack->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);

						$markerArray = array_merge($aMarkerArr, $rtMarkerArr);
						return $this->substituteMarkerArrayCached($template, $markerArray);
					}
				}
			}
		}
		return '';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getFriends.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getFriends.php']);
}

?>
