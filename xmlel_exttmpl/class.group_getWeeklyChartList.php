<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class group_getWeeklyChartList extends xmlel_exttmpl {
	
	protected $lastfm_api_func = array(
			'group.getWeeklyAlbumChart',
			'group.getWeeklyArtistChart',
			'group.getWeeklyTrackChart',
	);
	
	protected static $templateFieldDate = 'weeklychartlist_date';
	protected static $templateFieldMethod = 'weeklychartlist_method';
	
	public function __construct() {
		parent::__construct();
		
		$this->tagStruct = array(
			'chart' => array(
				'###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE###',
				'###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD###',
			),
		);
	}
	
	protected function fillTemplate() {
		$subpartArray = array();
		$template = $this->getTemplateParts('###TEMPLATE###');
		
		if ($this->checkUrlRequestArgs()) {
			$params = $this->getUrlRequestArgs();
			$method = $params['method'];
			unset($params['method']);
			
			/*DomDocument*/$dom = $this->tx_musicview_pi1->doRequest($method, $params);
			$iContent = $this->tx_musicview_pi1->workOnRequestResult($dom, $method);
			
			$subpartArray['###TEMPLATE_WEEKLYCHARTLIST_METHOD_RESULT###'] = $iContent;
		}
		
		return $this->displayXmlelObject($template['total'], $this->xmlel_obj, $subpartArray);
	}
	
	protected function fillSubpart($iSubTemplate, $objectArr, $templateKey) {
		$content = '';
		
		if ($templateKey == '###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD###') {
			foreach ($this->lastfm_api_func as $func) {
				$markerArray['###TEMPLATE_WEEKLYCHARTLIST_LASTFM_API_FUNC###'] = $func;
				$markerArray['###TEMPLATE_WEEKLYCHARTLIST_LASTFM_API_FUNC_NAME###'] = $this->getLL('tx_musicview_pi1_tmpl_weeklychartlist_lastfmapi_' . $func);

				$content .= $this->substituteMarkerArrayCached($iSubTemplate, $markerArray);
			}
		} else {
			$content = parent::fillSubpart($iSubTemplate, $objectArr, $templateKey);
		}
		
		return $content;
	}
	
	protected function getTemplateMarkers($xmlel_obj) {
		$markerArray = parent::getTemplateMarkers($xmlel_obj);
		
		if ($xmlel_obj instanceof xmlel_weeklychartlist) {
			$markerArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-DATE-NAME###'] = self::$templateFieldDate;
			$markerArray['###TEMPLATE_WEEKLYCHARTLIST-SELECT-METHOD-NAME###'] = self::$templateFieldMethod;
		}
		
		return $markerArray;
	}
	
	protected function checkUrlRequestArgs() {
		$params = $this->getUrlRequestArgs();

		if (is_array($params)) {
			$method = $params['method'];
			unset($params['method']);
			
			if ($this->tx_musicview_pi1->checkMethodParams($method, $params) &&
				$this->checkDate($params['from']) &&
				$this->checkDate($params['to'])) {
					return true;
			}
		}
		return false;
	}
	
	protected function getUrlRequestArgs() {
		$params = t3lib_div::_GET('tx_musicview_pi1');
		
		if (is_array($params)) {
			$fullDate = $params[self::$templateFieldDate];
			$method = $params[self::$templateFieldMethod];
			list($from, $to) = explode('-', $fullDate);
			
			$arr['method'] = $method;
			$arr['from'] = $from;
			$arr['to'] = $to;
			
			return $arr;
		}
		
		return false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.group_getWeeklyChartList.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.group_getWeeklyChartList.php']);
}
?>
