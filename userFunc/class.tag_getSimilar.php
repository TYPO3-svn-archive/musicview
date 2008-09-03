<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class tag_getSimilar extends musicview_userfunc_base {

	/**
	 * The name of the search field
	 */
	private $input = 'tag.getSimilar-INPUT-TAGNAME';
	
	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$method = $this->getMethodName();
		$tagValue = $this->getTagForInput($method);
		
		/* $template = $this->getTemplateParts('###TEMPLATE_SEARCH###', array());
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$markerArray['###TAG_TAG.REQ_TAG###'] = $tagValue;
		$markerArray['###TMPL_TAG_GETSIMILAR_PATH-tslib###'] = PATH_tslib;
		$tmplMarkerArray = $this->tx_musicview_pi1->getTemplateMarker();

		$part1 = $this->substituteMarkerArrayCached($template['total'], array_merge($markerArray, $tmplMarkerArray)); */
		$part2 = $this->displaySimilarTags($tagValue, $method);

		return /* $part1 . */ $part2;  
	}

	protected function displaySimilarTags($tagname, $method) {
		/*DomDocument*$dom = $this->tx_musicview_pi1->doRequest($method, array('tag' => $tagname));
		$domNodeList = $dom->getElementsByTagName(xmlel_lfm::XMLEL_NAME);
		
		if ($domNodeList->length == 1) {
			$xmlel_lfm = xmlel_lfm::lfmFactory($domNodeList);

			if ($xmlel_lfm->checkStatus()) { // ok
				$lConf = $this->tx_musicview_pi1->getRequestConf($method);
				$xmlel_objArr = $xmlel_lfm->getChild('similartags');
				$content = '';
				
				foreach ($xmlel_objArr as $xmlel_obj) {
					if ($xmlel_obj instanceof xmlel_similartags) {
						$content .= $this->displayObject($xmlel_obj);
					}
				}
				return $content;
			}
		}
		return NULL; */
		return $this->displayObject($this->xmlel_obj);
	}
	
	protected function displayObject($xmlel_obj) {
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_TAG###'));
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray['###TEMPLATE_TAG###'] = $this->displayTags($template['item0'], $xmlel_obj->getChild('tag'));

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	protected function displayTags($template, $tagArr) {
		$content = '';

		foreach ($tagArr as $tag) {
			$markerArray = $tag->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		return $content;
	}
	
	/**
	 * Get the value for the search field.
	 * 
	 * @return 	The value for the search field
	 */
	private function getTagForInput($method) {
		if ($this->isMethodParamSet()) {
			$params = t3lib_div::_GET('tx_musicview_pi1');
			$value = $params[$this->input];

			if (!is_null($value) && strlen($value) > 0) {
				return $value;
			}
		}
		$value = $this->tx_musicview_pi1->getFlexValue($method, 'tag');
		return $value; 
	}
	
	private function isMethodParamSet() {
		$params = t3lib_div::_GP('tx_musicview_pi1');
		
		if (is_array($params) && isset($params[$this->input])) {
			return true;
		}
		return false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']);
}
?>
