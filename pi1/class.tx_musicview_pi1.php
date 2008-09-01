<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Christoph Gostner <christoph.gostner@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(PATH_t3lib.'class.t3lib_xml.php');

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author	Christoph Gostner <christoph.gostner@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_musicview
 */
class tx_musicview_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_musicview_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_musicview_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'musicview';	// The extension key.
	var $pi_checkCHash = true;

	var $piFlexForm;

	protected $last_fm_req_base = 'http://ws.audioscrobbler.com/2.0/';
	public $last_fm_api = array(
		'_DEFAULT' => array(
			/* ###user.*### begin */
			'user' => array(
				'user' => array(
					'sheet' => 'sDEF',
					'key' => 'username_settings',
					'req' => 1,
				),
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###user.*### end */
			
			/* ###group.*### begin */
			'group' => array(
				'group' => array(
					'sheet' => 'sDEF',
					'key' => 'group_name',
					'req' => 1,
				),
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###group.*### end */
			
			/* ###geo.*### begin */
			'geo' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###geo.*### end */
			
			/* ###library.*### begin */
			'library' => array(
				'user' => array(
					'sheet' => 'sDEF',
					'key' => 'username_settings',
					'req' => 1,
				),
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###library.*### end */
		),

		/* ###user.*### begin */
		'user.getEvents' => array(
		),
		'user.getFriends' => array(
			'recenttracks' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getFriends_recenttracks',
				'req' => 0,
			),
			'limit' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getFriends_limit',
				'req' => 0,
			),
		),
		'user.getInfo' => array(
			'api_sig' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getInfo',
				'req' => 1,
			),
		),
		'user.getLovedTracks' => array(
		),
		'user.getNeighbours' => array(
			'limit' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getNeighbours',
				'req' => 0,
			),
		),
		'user.getPastEvents' => array(
			'page' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getPastEvents_page',
				'req' => '0',
			),
			'limit' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getPastEvents_limit',
				'req' => '0',
			),
		),
		'user.getPlaylists' => array(
		),
		'user.getRecentTracks' => array(
			'limit' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getRecentTracks',
				'req' => 0,
			),
		),
		'user.getTopAlbums' => array(
			'period' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getTopAlbums',
				'req' => 0,
			),
		),
		'user.getTopArtists' => array(
			'period' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getTopArtists',
				'req' => 0,
			),
		),
		'user.getTopTags' => array(
			'limit' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getTopTags',
				'req' => 0,
			),
		),
		'user.getTopTracks' => array(
			'period' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getTopTracks',
				'req' => 0,
			),
		),
		'user.getWeeklyAlbumChart' => array(
			'from' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyAlbumChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyAlbumChart_to',
				'req' => 0,
			),
		),
		'user.getWeeklyArtistChart' => array(
			'from' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyArtistChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyArtistChart_to',
				'req' => 0,
			),
		),
		'user.getWeeklyChartList' => array(
		),
		'user.getWeeklyTrackChart' => array(
			'from' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyTrackChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyTrackChart_to',
				'req' => 0,
			),
		),
		/* ###user.*### end */
			
		/* ###group.*### begin */
		'group.getWeeklyAlbumChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyAlbumChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyAlbumChart_to',
				'req' => 0,
			),
		),
		'group.getWeeklyArtistChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyArtistChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyArtistChart_to',
				'req' => 0,
			),
		),
		'group.getWeeklyChartList' => array(
		),
		'group.getWeeklyTrackChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyTrackChart_from',
				'req' => 0,
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyTrackChart_to',
				'req' => 0,
			),
		),
		/* ###group.*### end */
		
		/* ###geo.*### begin */
		'geo.getEvents' => array(
			'location' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getEvents_location',
				'req' => 0,
			),
			'lat' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getEvents_lat',
				'req' => 0,
			),
			'long' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getEvents_long',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getEvents_page',
				'req' => 0,
			),
			'distance' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getEvents_distance',
				'req' => 0,
			),
		),
		'geo.getTopArtists' => array(
			'country' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getTopArtists',
				'req' => 1,
			),
		),
		'geo.getTopTracks' => array(
			'country' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getTopTracks_country',
				'req' => 1,
			),
			'location' => array(
				'sheet' => 'sheet_geo_api',
				'key' => 'geo.getTopTracks_location',
				'req' => 0,
			),
		),
		/* ###geo.*### end */
		
		/* ###library.*### begin */
		'library.getAlbums' => array(
			'limit' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getAlbums_limit',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getAlbums_page',
				'req' => 0,
			),
		),
		'library.getArtists' => array(
			'limit' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getArtists_limit',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getArtists_page',
				'req' => 0,
			),
		),
		'library.getTracks' =>  array(
			'limit' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getTracks_limit',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_library_api',
				'key' => 'library.getTracks_page',
				'req' => 0,
			),
		),
		/* ###library.*### end */
	);
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
	
		$this->pi_initPIflexForm();
		$this->piFlexForm = $this->cObj->data['pi_flexform'];

		$method = $this->getFlexFormValue('sDEF', 'apifunc_setting');
		$dom = $this->doRequest($method);
		#return '';
		return $this->workOnRequestResult($dom, $method);
	}
	
	/**
	 * Create the request url and do the request. Return the
	 * dom document with the result.
	 * This method is used from the user_getWeeklyChartList class to create
	 * another request when the user updates his selection.
	 *
	 * @param 	string	$method: The request method
	 * @param	array	$param: To overwrite settings in the flexform configuration
	 * @return 	The DomDocument with the content
	 */
	public function doRequest($method, $param = array()) {
		$reqLink = $this->createRequestLink($method, $param);
		#t3lib_div::debug($reqLink);
		#return $reqLink;
		$reqLink = 'http://walnut-walnut/xml/'.$method . '.xml';
		$dom = new DomDocument('1.0', 'utf-8');
		$dom->load($reqLink);

		return $dom;
	}
	
	/**
	 * Work on the request result.
	 * First read the result in the xmlel data structure, then call the userFunc
	 * for all elements containig in the request's result.
	 * This method is used from the user_getWeeklyChartList class to create
	 * another request when the user updates his selection.
	 *
	 * @param 	DomDocument 	$dom:	The dom document
	 * @param 	string			$method:	The method to display
	 * @return 	The content to display
	 */
	public function workOnRequestResult($dom, $method) {
		$content = '';
		/*DOMNodeList*/$domNodeList = $dom->getElementsByTagName(xmlel_lfm::XMLEL_NAME);
		
		if ($domNodeList->length == 1) {
			$xmlel_lfm = xmlel_lfm::lfmFactory($domNodeList);

			if ($xmlel_lfm->checkStatus()) { // ok
				$lConf = $this->getRequestConf($method);
				$childKeys = $xmlel_lfm->getChildKeys();
				foreach ($childKeys as $childKey) {
					$childArr = $xmlel_lfm->getChild($childKey);
					
					foreach ($childArr as $childObj) {
						$userFuncContent = $this->callUserFunc($lConf, $childObj);
						$content .= $this->pi_wrapInBaseClass($userFuncContent);
					}
				}
			} else {
				$lConf = $this->getRequestConf('error');
				$errors = $xmlel_lfm->getChild('error');

				foreach ($errors as $error) {
					$userFuncContent = $this->callUserFunc($lConf, $error);	
					$content .= $this->pi_wrapInBaseClass($userFuncContent);
				}
				#return $this->pi_getLL('tx_musicview_pi1_incorrect_status');
			}
		}
		
		return $content;
	}

	/************************* ###USERFUNC### begin *******************************/
	/**
	 * Call the user function set by typoscript.
	 *
	 * @param	array	$conf: The configuration to get the user function
	 * @param	object	$xmlel_base: An xmlel_base object to display
	 * @return	The content of the user function or an error message
	 */
	private function callUserFunc($conf, $xmlel_base) {
		if (isset($conf['userFunc'])) {
			$userFunc = $conf['userFunc'];

			return t3lib_div::callUserFunction($userFunc, $xmlel_base, &$this, '');
		}
		return $this->pi_getLL('tx_musicview_pi1_no_userfunc');
	}

	/**
	 * Get the configuration for the request method.
	 *
	 * @param 	string	$method: The request method
	 * @return 	The request modthod's configuration
	 */
	public function getRequestConf($method) {
		$confSubs = explode(".", $method);
		$lConf = $this->conf;

		foreach ($confSubs as $sKey) {
			$key = $sKey . '.';
			$tmp = $lConf[$key];
			$lConf = $tmp;
		}
		return $lConf;
	}

	/************************* ###USERFUNC_HELP### begin **************************/
	/**
	 * Get the static markers for the templates.
	 *
	 * @return 	The static markers
	 */
	public function getTemplateMarker() {
		$markerArray = array(
			'###TMPL_ERROR_TITLE###' => $this->pi_getLL('tx_musicview_pi1_tmpl_error_title'),
			'###TMPL_EVENT_MARKER_DATE###' => $this->pi_getLL('tx_musicview_pi1_tmpl_event_marker_date'),
			'###TMPL_EVENT_MARKER_DESCRIPTION###' => $this->pi_getLL('tx_musicview_pi1_tmpl_event_marker_description'),
			'###TMPL_EVENT_MARKER_ARTISTS###' => $this->pi_getLL('tx_musicview_pi1_tmpl_event_marker_artists'),
			'###TMPL_EVENT_MARKER_HEADLINER###' => $this->pi_getLL('tx_musicview_pi1_tmpl_event_marker_headliner'),
			'###TMPL_WEEKLYCHARTLIST_MARKER_SUBMIT###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_submit'),
			'###TEMPLATE_WEEKLYCHARTLIST-FORM-TITLE###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_form_title'),
			'###TEMPLATE_WEEKLYCHARTLIST-FORM-ACTION-URL###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_form_action_url'),
			'###TMPL_WEEKLYCHARTLIST_NO_RESULT###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_no_result'),
		);
		return $markerArray;
	}
	
	/**
	 * Check if the parameters for the method are valid.
	 * 
	 * @param	string	$method: The method to check
	 * @param 	array	$params: The parameters to check
	 * @return If method and parameters match an entry in the $last_fm_api array
	 */
	public function checkMethodParams($method, $params) {
		$m_params = $this->getMethodParams($method);
		if (!is_null($m_params)) {
			
			foreach ($params as $key => $value) {
				if (!array_key_exists($key, $m_params) || is_null($value) || strlen($value) == 0) {
					return false; 
				}
			}
			return true;
		}
		return false;
	}
	
	/************************* ###USERFUNC_HELP### end ****************************/
	
	/************************* ###USERFUNC### begin *******************************/

	/**
	 * Get the parameters for the method.
	 * 
	 * @param 	string	$method: The name of the method to build
	 * @return 	The parameters for the request url
	 */
	private function getMethodParams($method) {
		if (array_key_exists($method, $this->last_fm_api)) {
			$req_params_keys = $this->getDefaultConfByMethod($method);
			$req_params = $this->getParamArray($req_params_keys);
			
			$opt_params = $this->getParamArray($this->last_fm_api[$method]);
			$req_params = array_merge($req_params, $opt_params);
			
			return $req_params;
		}
		return NULL;
	}
	
	/**
	 * Create the request url to get the information from last.fm.
	 *
	 * @param 	string	$method: The request method
	 * @param	array	$params: To overwrite settings in flexform
	 * @return	The request url
	 */
	private function createRequestLink($method, $params) {
		if (!is_null($req_params)) {
			$req_params = $this->overwriteParams($req_params, $params);
			
			$url = $this->last_fm_req_base . '?method=' . $method;
			foreach ($req_params as $key => $values) {
				$value = $values['val'];
				$url .= '&' . $key . '=' . $value;
			}
			return $url;
		}
		return NULL;
	}
	
	/**
	 * Method to extract the required arguments for a certain method.
	 *
	 * @param 	string	$method: The method's content to display
	 * @return	The array with flexform keys to use.
	 */
	private function getDefaultConfByMethod($method) {
		$key = substr($method, 0, strpos($method, '.'));
		$a = $this->last_fm_api['_DEFAULT'][$key];
		
		return $a;
	}
	
	/** 
	 * Overwrite some values in the method's argument array.
	 * 
	 * @param	array	$origArr: The original array with the values
	 * @param	array	$overwriteArr: The new values to use
	 * @return 	The array with the new method's argument
	 */ 
	private function overwriteParams($origArr, $overwriteArr) {
		foreach ($overwriteArr as $key => $value) {
			$origArr[$key]['val'] = $value;
		}
		return $origArr;
	}

	/**
	 * Get the parameter array for the request link. Called for the _DEFAULT parameters
	 * and for optional parameters, when the method required them.
	 * 
	 * @param 	array	$arr: The parameter array for the request link
	 * @return	The parameters for the request url
	 */
	private function getParamArray($arr) {
		$result = array();
		foreach ($arr as $key => $values) {
			$rKey = $values['req'];
			$vKey = $this->getFlexFormValue($values['sheet'], $values['key']);

			if ($rKey || (!is_null($vKey) && $vKey != 0)) {
				$result[$key] =  array(
							'req'	=> $rKey, 
							'val' 	=> $vKey
						);
			}
		}
		return $result;
	}

	/**
	 * Get the value out of the saved flexform. Stay attention, this method's argument
	 * order isn't the same as the orignial typo3 function to access the values!
	 *
	 * @param string $sheet The sheet that should contain the key.
	 * @param string $key The key to identify the value.
	 * @return The value in the sheet.
	 */
	private function getFlexFormValue($sheet, $key) {
		return $this->pi_getFFvalue($this->piFlexForm, $key, $sheet);
	}
}
 
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/class.tx_musicview_pi1.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/class.tx_musicview_pi1.php']);
}
 
?>
