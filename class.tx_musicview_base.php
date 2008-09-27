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

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');


/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author	Christoph Gostner <christoph.gostner@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_musicview
 */
abstract class tx_musicview_base extends tslib_pibase {
	var $extKey        = 'musicview';	// The extension key.
	var $pi_checkCHash = true;
	var $piFlexForm;
	
	/**
	 * The base URL for the requests
	 * 
	 * @var string
	 */
	private $last_fm_req_base = 'http://ws.audioscrobbler.com/2.0/';
	/**
	 * This array configurates all the methods and it's parameters for
	 * the last.fm API. 
	 * 
	 * @var array
	 */
	protected $last_fm_api = array(
		'_DEFAULT' => array(
			/* ###album.*### end */
			'album' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###album.*### end */
			
			/* ###artist.*### begin */
			'artist' => array(
				'artist' => array(
					'sheet' => 'sheet_artist_api',
					'key' => 'artist.common',
					'req' => 1,
				),
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###artist.*### end */
			
			/* ###event.*### begin */
			'event' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
				'event' => array(
					'sheet' => 'sheet_event_api',
					'key' => 'event.common',
					'req' => 1,
				),
			),
			/* ###event.*### end */
			
			/* ###geo.*### begin */
			'geo' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###geo.*### end */
			
			/* ###group.*### begin */
			'group' => array(
				'group' => array(
					'sheet' => 'sheet_group_api',
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
			
			/* ###library.*### begin */
			'library' => array(
				'user' => array(
					'sheet' => 'sheet_user_api',
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
			
			/* ###playlist.*### begin */
			'playlist' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###playlist.*### end */
			
			/* ###tag.*### begin */
			'tag' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###tag.*### end */
			
			/* ###tasteometer.*### begin */
			'tasteometer' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###tasteometer.*### end */
			
			/* ###track.*### begin */
			'track' => array(
				'api_key' => array(
					'sheet' => 'sDEF',
					'key' => 'apikey_settings',
					'req' => 1,
				),
			),
			/* ###track.*### end */
			
			/* ###user.*### begin */
			'user' => array(
				'user' => array(
					'sheet' => 'sheet_user_api',
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
		),

		/* ###album.*### start */
		'album.getInfo' => array(
			'artist' => array(
				'sheet' => 'sheet_album_api',
				'key' => 'album.getInfo_artist',
				'req' => 0,
			),
			'album' => array(
				'sheet' => 'sheet_album_api',
				'key' => 'album.getInfo_album',
				'req' => 0,
			),
			'mbid' => array(
				'sheet' => 'sheet_album_api',
				'key' => 'album.getInfo_mbid',
				'req' => 0,
			),
		),
		/* ###album.*### end */
				
		/* ###artist.*### start */
		'artist.getEvents' => array(
		),
		'artist.getInfo' => array(
			'mbid' => array(
				'sheet' => 'sheet_artist_api',
				'key' => 'artist.getInfo_mbid',
				'req' => 0,
			),
		),
		'artist.getSimilar' => array(
			'limit' => array(
				'sheet' => 'sheet_artist_api',
				'key' => 'artist.getSimilar_limit',
				'req' => 0,
			),
		),
		'artist.getTopAlbums' => array(
		),
		'artist.getTopFans' => array(
		),
		'artist.getTopTags' => array(
		),
		'artist.getTopTracks' => array(
		),
		'artist.search' => array(
			'page' => array(
				'sheet' => 'sheet_artist_api',
				'key' => 'artist.search_page',
				'req' => 0,
			),
			'limit' => array(
				'sheet' => 'sheet_artist_api',
				'key' => 'artist.search_limit',
				'req' => 0,
			),
		),
		/* ###artist.*### end */
		
		/* ###auth.*### start */
		/* ###auth.*### end */
				
		/* ###event.*### start */
		'event.getInfo' => array(
		),
		/* ###event.*### end */
				
		/* ###geo.*### start */
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
				
		/* ###group.*### start */
		'group.getWeeklyAlbumChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyAlbumChart_from',
				'req' => 0,
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyAlbumChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		'group.getWeeklyArtistChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyArtistChart_from',
				'req' => 0,
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyArtistChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		'group.getWeeklyChartList' => array(
		),
		'group.getWeeklyTrackChart' => array(
			'from' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyTrackChart_from',
				'req' => 0,
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_group_api',
				'key' => 'group.getWeeklyTrackChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		/* ###group.*### end */		
				
		/* ###library.*### start */
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
		
		/* ###playlist.*### start */
		'playlist.fetch' => array(
			'playlistURL' => array(
				'sheet' => 'sheet_playlist_api',
				'key' => 'playlist.fetch',
				'req' => 1,
			),
		),
		/* ###playlist.*### end */
		
		/* ###tag.*### start */
		'tag.getSimilar' => array(
			'tag' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.req_tag',
				'req' => 1,
			),
		),
		'tag.getTopAlbums' => array(
			'tag' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.req_tag',
				'req' => 1,
			),
		),
		'tag.getTopArtists' => array(
			'tag' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.req_tag',
				'req' => 1,
			),
		),
		'tag.getTopTags' => array(
		),
		'tag.getTopTracks' => array(
			'tag' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.req_tag',
				'req' => 1,
			),
		),
		'tag.search' => array(
			'tag' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.req_tag',
				'req' => 1,
			),
			'limit' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.search_limit',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_tag_api',
				'key' => 'tag.search_page',
				'req' => 0,
			),
		),
		/* ###tag.*### end */
				
		/* ###tasteometer.*### start */
		'tasteometer.compare' => array(
			'type1' => array(
				'sheet' => 'sheet_tastemeter_api',
				'key' => 'tasteometer.compare_type1',
				'req' => 1,
			),
			'type2' => array(
				'sheet' => 'sheet_tastemeter_api',
				'key' => 'tasteometer.compare_type2',
				'req' => 1,
			),
			'value1' => array(
				'sheet' => 'sheet_tastemeter_api',
				'key' => 'tasteometer.compare_value1',
				'req' => 1,
			),
			'value2' => array(
				'sheet' => 'sheet_tastemeter_api',
				'key' => 'tasteometer.compare_value2',
				'req' => 1,
			),
			'limit' => array(
				'sheet' => 'sheet_tastemeter_api',
				'key' => 'tasteometer.compare_limit',
				'req' => 0,
			),
		),
		/* ###tasteometer.*### end */
				
		/* ###track.*### start */
		'track.getInfo' => array(
			'track' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_track',
				'req' => 0,
			),
			'artist' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_artist',
				'req' => 0,
			),
			'mbid' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_mbid',
				'req' => 0,
			),
		),
		'track.getSimilar' => array(
			'track' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_track',
				'req' => 0,
			),
			'artist' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_artist',
				'req' => 0,
			),
			'mbid' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_mbid',
				'req' => 0,
			),
		),
		'track.getTopFans' => array(
			'track' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_track',
				'req' => 0,
			),
			'artist' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_artist',
				'req' => 0,
			),
			'mbid' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_mbid',
				'req' => 0,
			),
		),
		'track.getTopTags' => array(
			'track' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_track',
				'req' => 0,
			),
			'artist' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_artist',
				'req' => 0,
			),
			'mbid' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_mbid',
				'req' => 0,
			),
		),
		'track.search' => array(
			'track' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_track',
				'req' => 1,
			),
			'artist' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.getTopTags-getTopFans-getSimilar_artist',
				'req' => 0,
			),
			'page' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.search_page',
				'req' => 0,
			),
			'limit' => array(
				'sheet' => 'sheet_track_api',
				'key' => 'track.search_limit',
				'req' => 0,
			),
		),
		/* ###track.*### end */
		
		/* ###user.*### start */
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
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyAlbumChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		'user.getWeeklyArtistChart' => array(
			'from' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyArtistChart_from',
				'req' => 0,
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyArtistChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		'user.getWeeklyChartList' => array(
		),
		'user.getWeeklyTrackChart' => array(
			'from' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyTrackChart_from',
				'req' => 0,
				'frmt' => 'date',
			),
			'to' => array(
				'sheet' => 'sheet_user_api',
				'key' => 'user.getWeeklyTrackChart_to',
				'req' => 0,
				'frmt' => 'date',
			),
		),
		/* ###user.*### end */
	);
	
	/**
	 * Set the flexform object.
	 */
	public function init($conf) {
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm();
		
		$this->piFlexForm = $this->cObj->data['pi_flexform'];
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
		if ($this->conf['debugURL']) {
			t3lib_div::debug(array($method => $reqLink));
			t3lib_div::debug(array());
		}
		if ($this->conf['localXML']) {
			$reqLink = t3lib_extMgm::extPath('musicview') . '/examples/'.$method.'.xml';
		}
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
		/*DOMNodeList*/$domNodeList = $dom->getElementsByTagName(xmlel_lfm::XMLEL_NAME);
		
		if ($domNodeList->length == 1) {
			$content = '';
			$xmlel_lfm = xmlel_lfm::lfmFactory($domNodeList);

			if ($xmlel_lfm->checkStatus()) { // ok
				$lConf = $this->getRequestConf($method);
				$childKeys = $xmlel_lfm->getChildKeys();
				
				foreach ($childKeys as $childKey) {
					$childArr = $xmlel_lfm->getChild($childKey);
					foreach ($childArr as $childObj) {
						$userFuncContent = $this->callUserFunc($lConf, $childObj, $method);
						$content .= $this->pi_wrapInBaseClass($userFuncContent);
					}
				}
			} else {
				$lConf = $this->getRequestConf('error');
				$errors = $xmlel_lfm->getChild('error');

				foreach ($errors as $error) {
					$userFuncContent = $this->callUserFunc($lConf, $error, 'error');
					$content .= $this->pi_wrapInBaseClass($userFuncContent);
				}
			}
			return $content;
		}
		return $this->pi_getLL('tx_musicview_pi1_incorrect_status');
	}

	/************************* ###USERFUNC### begin *******************************/
	/**
	 * Call the user function set by typoscript.
	 *
	 * @param	array	$conf: The configuration to get the user function
	 * @param	object	$xmlel_base: An xmlel_base object to display
	 * @param	string	$method: The method result to display
	 * @param 	object	$self: Class object
	 * @return	The content of the user function or an error message
	 */
	protected function callUserFunc($conf, $xmlel_base, $method) {
		if (isset($conf['userFunc'])) {
			$userFunc = $conf['userFunc'];

			$xmlel_base->setApiMethod($method);
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
			'###TMPL_WEEKLYCHARTLIST-FORM-ACTION-URL###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_form_action_url'),
			'###TMPL_WEEKLYCHARTLIST_NO_RESULT###' => $this->pi_getLL('tx_musicview_pi1_tmpl_weeklychartlist_no_result'),
			'###TMPL_CURRENTPAGE-FORM-ACTION-URL###' => $this->pi_linkTP_keepPIvars_url(),
			'###TMPL_TAG_GETSIMILAR-SUBMIT###' => $this->pi_getLL('tx_musicview_pi1_tmpl_tag_getsimilar-submit'),
			'###TMPL_TAG_GETSIMILAR-FORM-TITLE###' => $this->pi_getLL('tx_musicview_pi1_tmpl_tag_getsimilar-form-title'),
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
		if (!is_null($m_params) && is_array($params)) {
			
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
	 * Create the request url to get the information from last.fm.
	 *
	 * @param 	string	$method: The request method
	 * @param	array	$params: To overwrite settings in flexform
	 * @return	The request url
	 */
	protected function createRequestLink($method, $params) {
		$defaultParams = $this->getDefaultConf($method);
		$methodParams = $this->getMethodParams($method);
		$requestParams = array_merge($defaultParams, $methodParams);
		$requestParams = $this->overwriteParams($requestParams, $params);
		#t3lib_div::debug($requestParams);
		
		$url = $this->last_fm_req_base . '?method=' . $method;
		foreach ($requestParams as $key => $value) {
			$url .= '&' . $key . '=' . $value;
		}
		return $url;
	}
	
	/**
	 * Method to extract the required arguments for a certain method.
	 *
	 * @param 	string	$method: The method's content to display
	 * @return	The array with flexform keys to use.
	 */
	protected function getDefaultConf($method) {
		$key = substr($method, 0, strpos($method, '.'));
		$a = $this->last_fm_api['_DEFAULT'][$key];
		
		return $a;
	}
	
	/**
	 * Get the parameters for the method.
	 * 
	 * @param string $method The name of the method to build
	 * @return The parameters for the request url
	 * @author Christoph Gostner
	 */
	protected function getMethodParams($method) {
		if (array_key_exists($method, $this->last_fm_api)) {
			return $this->last_fm_api[$method];
		}
		/* we return an empty array to prevent errors */
		return array();
	}
	
	/** 
	 * Overwrite some values in the method's argument array. 
	 * The method overwrites only values that aren't marked as required 
	 * in the configuration array.
	 * 
	 * @param array $origArr The original array with the values
	 * @param array $overwriteArr The new values to use
	 * @return The array with the new method's argument
	 * @author Christoph Gostner
	 */ 
	protected function overwriteParams($methodParams, $overwriteParams) {
		$arr = array();
		foreach ($methodParams as $key => $paramLocation) {
			$flexSheet = $paramLocation['sheet'];
			$flexKey = $paramLocation['key'];
			$flexReq = $paramLocation['req'];
			$flexFrmt = $paramLocation['frmt'];
			
			if (!$flexReq && (is_array($overwriteParams) && array_key_exists($key, $overwriteParams))) {
				$value = $overwriteParams[$key];
			} else {
				$value = $this->getFlexFormValue($flexSheet, $flexKey);
			}
			
			if ($flexReq || (!is_null($value) && $value > 0)) {
				if (!is_null($flexFrmt) && strncmp('date', $flexFrmt, 4) == 0) {
					if (isset($this->conf['modifyTime'])) {
						$value += $this->conf['modifyTime'];
					}
				}
				$arr[$key] = $value;
			}
		}
		return $arr;
	}

	/**
	 * Get the value out of the saved flexform. Stay attention, this method's argument
	 * order isn't the same as the orignial typo3 function to access the values!
	 *
	 * @param string $sheet The sheet that should contain the key.
	 * @param string $key The key to identify the value.
	 * @return The value in the sheet.
	 * @author Christoph Gostner
	 */
	protected function getFlexFormValue($sheet, $key) {
		return $this->pi_getFFvalue($this->piFlexForm, $key, $sheet);
	}
}
 
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/class.tx_musicview_base.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/class.tx_musicview_base.php']);
}
 
?>
