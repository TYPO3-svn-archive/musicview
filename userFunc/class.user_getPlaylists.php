<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getPlaylists extends musicview_userfunc_base {

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$content = '';
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_PLAYLIST###'));

		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$playlist = $this->xmlel_obj->getChild('playlist');

		$subpartArray['###TEMPLATE_PLAYLIST###'] = $this->displayPlaylistsContent($playlist, $template['item0']);
		
		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	private function displayPlaylistsContent($playlists, $template) {
		$content = '';

		foreach ($playlists as $playlist) {
			$markerArray = $playlist->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}

		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getPlaylists.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getPlaylists.php']);
}
?>
