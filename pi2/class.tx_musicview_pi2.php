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

require_once (t3lib_extMgm::extPath('musicview').'class.tx_musicview_base.php');


/**
 * Plugin 'musicview search' for the 'musicview' extension.
 *
 * @author	Christoph Gostner <christoph.gostner@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_musicview
 */
class tx_musicview_pi2 extends tx_musicview_base {
	var $prefixId      = 'tx_musicview_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_musicview_pi2.php';	// Path to this script relative to the extension dir.
	var $invalidMethods;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		$this->init($conf);
		
		if (!$this->setTemplate($this->conf)) {
			return $this->pi_getLL('tx_musicview_pi2_template_not_found');
		}
		
		$template = $this->getTemplateParts('###TEMPLATE###', array('###TEMPLATE_NAMESPACE_AREA###',
																'###TEMPLATE_NAMESPACE_METHODS###',
																'###TEMPLATE_METHOD_AREA_INPUT###',
																'###TEMPLATE_SEARCH_RESULT###'));
		$markerArray['###TMPL_URL_ACTION###'] = $this->pi_linkTP_keepPIvars_url();
		$markerArray['###TMPL_SEARCH_TITLE###'] = 'search'; // TODO
		$markerArray['###TMPL_NAMESPACE_TITLE###'] = 'namespace: '; // TODO
		
		$subpartArray['###TEMPLATE_NAMESPACE_AREA###'] = $this->fillNamespace($template['item0']);
		$subpartArray['###TEMPLATE_NAMESPACE_METHODS###'] = $this->fillMethod($template['item1']);
		$subpartArray['###TEMPLATE_METHOD_AREA_INPUT###'] = $this->fillMethodArea($template['item2']);
		$subpartArray['###TEMPLATE_SEARCH_RESULT###'] = $this->fillResultArea($template['item3']);
		
		$content = $this->cObj->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
		
		return $this->pi_wrapInBaseClass($content);
	}
	
	/**
	 * Fill the tempaltes with the namespaces.
	 * 
	 * @return 	The filled content.
	 */
	protected function fillNamespace($template) {
		$namespaceArr = $this->getFilterNamespace();
		$select = $this->getFormParamValue('namespace');
		$content = '';
		
		foreach ($namespaceArr as $namespace) {
			if (strcmp($namespace, $select) == 0) 
				$markerArray['###TMPL_NAMESPACE_SELECTED###'] = 'selected="selected"'; 
			else 
				$markerArray['###TMPL_NAMESPACE_SELECTED###'] = '';
			$markerArray['###TMPL_NAMESPACE###'] = $namespace;
			$markerArray['###TMPL_NAMESPACE_LL###'] = $namespace; // TODO
			
			$content .= $this->cObj->substituteMarkerArrayCached($template, $markerArray);
		}
		return $content;
	}
	
	/**
	 * Fill the method content if a namespace is selected.
	 * 
	 * @param	mixed $template: The template to fill
	 * @return 	The filled template
	 */
	protected function fillMethod($template) {
		$subTemplate = $this->getSubTemplate($template, '###TEMPLATE_NAMESPACE_METHODS_CONTENT###');
		$select = $this->getFormParamValue('namespace');
		$namespaceArr = $this->getFilterNamespace();
		
		if (in_array($select, $namespaceArr)) {
			$subpartArray['###TEMPLATE_NAMESPACE_METHODS_CONTENT###'] = $this->fillMethodBox($subTemplate, $select);
		} else {
			$subpartArray['###TEMPLATE_NAMESPACE_METHODS_CONTENT###'] = '';
		}
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
	}
	
	/**
	 * Fill the selct box with methods.
	 * 
	 * @param	mixed	$template: The template to fill
	 * @param	string	$namespace: The selected namespace
	 * @return	The filled tempalte
	 */
	protected function fillMethodBox($template, $namespace) {
		$subTemplate = $this->getSubTemplate($template, '###TEMPLATE_METHOD_AREA###');
		$methodArr = $this->getFilterMethods($namespace);
		$select = $this->getFormParamValue('method');
		$content = '';
		
		foreach ($methodArr as $method) {
			if (strcmp($method, $select) == 0)
				$markerArray['###TMPL_METHOD_SELECTED###'] = 'selected="selected"'; 
			else 
				$markerArray['###TMPL_METHOD_SELECTED###'] = '';
			
			$markerArray['###TMPL_METHOD###'] = $method;
			$markerArray['###TMPL_METHOD_LL###'] = $method; // TODO
			
			$content .= $this->cObj->substituteMarkerArrayCached($subTemplate, $markerArray);
		}
		$markerArray['###TMPL_NAMESPACE_METHOD_TITLE###'] = 'methods:'; // TODO
		$subpartArray['###TEMPLATE_METHOD_AREA###'] = $content;
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
	}
	
	protected function fillMethodArea($template) {
		$nSelect = $this->getFormParamValue('namespace');
		$mSelect = $this->getFormParamValue('method');

		$methodArr = $this->getFilterMethods($nSelect);
		
		if (in_array($mSelect, $methodArr)) {
			$subTemplate = $this->getSubTemplate($template, '###TEMPLATE_METHOD_AREA_INPUT_FIELDS###');
			$subpartArray['###TEMPLATE_METHOD_AREA_INPUT_FIELDS###'] = $this->fillMethodAreaInputFields($subTemplate, $nSelect, $mSelect);
			
			$markerArray['###TMPL_SEARCH_SUBMIT###'] = 'Search'; // TODO
			return $this->cObj->substituteMarkerArrayCached($template, $markerArray, $subpartArray);
		} else {
			return '';
		}
	}
	
	/**
	 * If the method exits in the configuration array fill the input area with
	 * the input fields avaiable for the selected method.
	 * 
	 * @param	mixed 	$template: The template to fill
	 * @param	string	$namespace: The namespace of the method
	 * @param	string	$method: The method to display
	 * @return	The filled template
	 */
	protected function fillMethodAreaInputFields($template, $namespace, $method) {
		if (array_key_exists($namespace.'.', $this->conf)) {
			$namespaceMethods = $this->conf[$namespace.'.'];
			$method = substr($method, strlen($namespace.'.'), strlen($method));
			$content = '';
			
			if (array_key_exists($method.'.', $namespaceMethods)) {
				$paramArr = $this->getPi2MethodParams($namespace, $method);
			
				foreach ($paramArr as $param) {
					$markerArray['###TMPL_SEARCH_TEXT###'] = $param; // TODO
					$markerArray['###TMPL_INPUT_KEY###'] = $param;
					$markerArray['###TMPL_INPUT_VALUE###'] = $this->getFormParamValue($param);
					
					$content .= $this->cObj->substituteMarkerArrayCached($template, $markerArray);
				}
			}
			return $content;
		}
		return '';
	}
	
	/**
	 * If a valid method is selected and a parameter for the method is submittet, 
	 * make a request and present the result.
	 * 
	 * @param 	mixed	$template: The template to fill
	 */
	protected function  fillResultArea($template) {
		$nSelect = $this->getFormParamValue('namespace');
		$mSelect = $this->getFormParamValue('method');
		$method = substr($mSelect, strlen($nSelect.'.'), strlen($mSelect));
		$methodArr = $this->getFilterMethods($nSelect);
		
		if (in_array($mSelect, $methodArr)) {
			$paramArr = $this->getPi2MethodParams($nSelect, $method);
			
			$pArr = array();
			foreach ($paramArr as $param) {
				$val = $this->getFormParamValue($param);
				if (!is_null($val) && strlen($val) > 0) {
					$pArr[$param] = $val;
				}
			}
			if (count($pArr) > 0) {
				$method = $nSelect . '.' . $method;
				t3lib_div::debug($pArr);
				$dom = $this->doRequest($method, $pArr);
				return $this->workOnRequestResult($dom, $method, &$this);
			}
		}
		return '';
	}

	/**
	 * Get the parameters for the selected method.
	 * Returns all parameters expect the api key for the extension.
	 * 
	 * @param 	string	$namespace: The key to identify the required parameters for all
	 * @param 	string	$method: The method which parameters should be returned
	 * @return 	The array with all parameters for a method (expect the api key)
	 */
	protected function getPi2MethodParams($namespace, $method) {
		$req = array_keys($this->last_fm_api['_DEFAULT'][$namespace]);
		$opt = array_keys($this->last_fm_api[$namespace.'.'.$method]);
		
		$mix = array_merge($req, $opt);
		
		$index = array_search('api_key', $mix);
		unset($mix[$index]);
		
		return $mix;
	}
	
	/**
	 * Get the valid methods for a namespace.
	 * 
	 * @param 	string	$namespace: The selected namespace
	 * @return 	The array with valid methods
	 */
	public function getFilterMethods($namespace) {
		$methods = array_keys($this->last_fm_api);
		$invalidMethods = $this->conf['methods.']['invalid.'];
		$result = array();
		
		foreach ($methods as $method) {
			
			if (strncmp($method, $namespace, strlen($namespace)) == 0 &&
				!in_array($method, $invalidMethods)) {
				array_push($result, $method);
			}
		}
		return $result;
	}
	
	/**
	 * Get an array with the valid namespaces the user can search.
	 * 
	 * @return 	An array with valid namespaces
	 */
	protected function getFilterNamespace() {
		$namespaces = array_keys($this->last_fm_api['_DEFAULT']);
		$invalidNamespaces = $this->conf['namespace.']['invalid.'];
		
		return array_diff($namespaces, $invalidNamespaces);
	}
	
	/**
	 * Get a value from the url (GET/POST).
	 * 
	 * @param	string	$param: The key name of the value
	 * @return	The value identified by $param
	 */
	protected function getFormParamValue($param) {
		$params = t3lib_div::_GP('tx_musicview_pi2');
		
		if (is_array($params) && isset($params[$param])) {
			return $params[$param];
		}
		
		return false;
	}
	
	/**
	 * This functions sets the templateCode attribute. If the templateCode is set
	 * correct and it's a file the function returns true, else false.
	 * 
	 * @param 	array 	$conf: The configuration for the extension
	 * @return 	true if the templateCode is set correcty
	 */
	private function setTemplate($conf) {
		$this->templateCode = $this->cObj->fileResource($conf['templateFile']);
 
		return !is_null($this->templateCode);
	}
	
	/**
	 * This function gets template suparts out of the main template. 
	 * The parameter $total declears the template part to select, the items
	 * declear subparts of the main template code.
	 *
	 * @param 	string	$total: The main template part.
	 * @param 	array 	$items: The subparts to select.
	 * @return	The template and subparts in one array.
	 */
	protected function getTemplateParts($total, $items = array()) {
		$template['total'] = $this->getSubTemplate($this->templateCode, $total);
	 
		for ($i = 0; $i < count($items); $i++) {
			$template['item' . $i] = $this->getSubTemplate($template['total'], $items[$i]);
		}
		return $template;
	}

	/**
	 * Get the subpart template part out of the main template.
	 *
	 * @param	mixed 	$template: template
	 * @param	string	$subpart: Key for the subpart
	 * @return	Subpart template
	 */
	protected function getSubTemplate($template, $subpart) {
		return $this->cObj->getSubpart($template, $subpart);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi2/class.tx_musicview_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi2/class.tx_musicview_pi2.php']);
}

?>
