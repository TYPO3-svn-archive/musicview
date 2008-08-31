<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getWeeklyChartList extends musicview_userfunc_base {

	protected static $templateFieldDate = 'weeklychartlist_date';
	protected static $templateFieldMethod = 'weeklychartlist_method';
	
	protected $lastfm_api_func = array(
			'user.getWeeklyAlbumChart',
			'user.getWeeklyArtistChart',
			'user.getWeeklyTrackChart',
	);

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_WEEKLYCHARTLIST###', '###TEMPLATE_WEEKLYCHARTLIST_METHOD_RESULT###'));
	
		$markerArray = array();
		$subpartArray['###TEMPLATE_WEEKLYCHARTLIST###'] = $this->displayWeeklyChartList($this->xmlel_obj->getChild('chart'), $template['item0']);
		$subpartArray['###TEMPLATE_WEEKLYCHARTLIST_METHOD_RESULT###'] = $this->displayWeeklyChartListMethodResult($template['item1']);
		
		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	/**
	 * Fill the select boxes with the date to select and the possible methods avaiable for requests.
	 * 
	 * @param 	array	$charts: The list of possible charts 
	 * @param	mixed	$template: The template to use
	 * @return	The content for the update box
	 */
	protected function displayWeeklyChartList($charts, $template) {
		$sTemplate = $this->getSubTemplate($template, '###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE###');
		$content = '';

		foreach ($charts as $chart) {
			$markerArray = $chart->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($sTemplate, $markerArray);
		}

		$subpartArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE###'] = $content;

		$content = '';
		$sTemplate = $this->getSubTemplate($template, '###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD###');

		foreach ($this->lastfm_api_func as $func) {
			$markerArray['###TEMPLATE_WEEKLYCHARTLIST_LASTFM_API_FUNC###'] = $func;
			$markerArray['###TEMPLATE_WEEKLYCHARTLIST_LASTFM_API_FUNC_NAME###'] = $this->getLL('tx_musicview_pi1_tmpl_weeklychartlist_lastfmapi_' . $func);

			$content .= $this->substituteMarkerArrayCached($sTemplate, $markerArray);
		}
		$subpartArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD###'] = $content;
		
		$markerArray = $this->tx_musicview_pi1->getTemplateMarker();
		$markerArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE-NAME###'] = self::$templateFieldDate;
		$markerArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD-NAME###'] = self::$templateFieldMethod;

		return $this->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
	}
	
	/**
	 * If the params are set correctly, display the selected method's content within
	 * the selected date.
	 * 
	 * @param 	mixed	$template: The template to use
	 * @return 	The content for the weekly charts
	 */
	protected function displayWeeklyChartListMethodResult($template) {
		$params = t3lib_div::_GET('tx_musicview_pi1');
		
		if (is_array($params)) {
			$fullDate = $params[self::$templateFieldDate];
			$method = $params[self::$templateFieldMethod];
			list($from, $to) = explode('-', $fullDate);
			$params = array('from' => $from, 'to' => $to);
			
			if ($this->tx_musicview_pi1->checkMethodParams($method, $params) &&
				$this->checkDate($params['from']) &&
				$this->checkDate($params['to'])) {
				/*DomDocument*/$dom = $this->tx_musicview_pi1->doRequest($method, $params);
				return $this->tx_musicview_pi1->workOnRequestResult($dom, $method);
			}
		} else {
			$markerArray = $this->tx_musicview_pi1->getTemplateMarker();
			
			return $this->substituteMarkerArrayCached($template, $markerArray);
		}
		return $this->tx_musicview_pi1->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_lastfmapi_method_not_found');
	}
	
	/**
	 * TODO: rewrite
	 * 
	 * Check if the timestamp is valid.
	 * 
	 * @param 	string	$timestamp: The timestamp to check
	 * @return 	If the timestamp is valid
	 */
	protected function checkDate($timestamp) {
		$now = time();
		
		if ($timestamp > 0 && $timestamp < $now) {
			return true;
		}
		return false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyChartList.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyChartList.php']);
}

?>
