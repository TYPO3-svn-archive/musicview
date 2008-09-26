<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_exttmpl {
	
	protected $tx_musicview_pi1;
	protected $xmlel_obj;
	protected $conf;
	
	protected $tagStruct;
	
	public function __construct() {
		$this->tagStruct = array();
	}
	
	/**
	 * Initialise the xmlel_exttempl object and fill the template with the information from the
	 * xmlel object.
	 * 
	 * @param	xmlel_base	$xmlel_obj: The object with the information to fill the template
	 * @param 	tx_musicview_pi1	$tx_musicview_pi1: Reference to the caller class
	 * @return 	The content of the xmlel object
	 */
	public function xmlel_exttmpl_init($xmlel_obj, $tx_musicview_pi1) {
		$this->xmlel_obj = $xmlel_obj;
		$this->tx_musicview_pi1 = $tx_musicview_pi1;
		$this->conf = $this->tx_musicview_pi1->getRequestConf($xmlel_obj->getApiMethod());
		
		if (!is_array($this->conf)) {
			return $this->getLL('tx_musicview_pi1_conf_not_found');
		}
 
		if (!$this->setTemplate($this->conf)) {
			return $this->getLL('tx_musicview_pi1_template_not_found');
		}

		return $this->fillTemplate();
	}
	
	/**
	 * Fill the template with the local xmlel object.
	 * 
	 * @return 	The template filled with information from the xmlel object
	 */
	protected function fillTemplate() {
		$template = $this->getTemplateParts('###TEMPLATE###');
		return $this->displayXmlelObject($template['total'], $this->xmlel_obj);
	}
	
	/**
	 * Fill the template with information from the xmlel object.
	 *  
	 * @param 	mixed	$template: The template to fill
	 * @param 	xmlel_base	$xmlel_obj: The object's information used to fill the template
	 * @param 	array 	$glSubpartArrray: 
	 * @return	The filled template
	 */
	protected function displayXmlelObject($template, $xmlel_obj, $glSubpartArrray = array()) {
		$childKeys = $xmlel_obj->getChildKeys();
		$subpartArray = array();
		$markerArray = $this->getTemplateMarkers($xmlel_obj);
		
		foreach ($childKeys as $childKey) {
			$objectArr = $xmlel_obj->getChild($childKey);
			
			if (count($objectArr) > 0) {
				$templateKeys = array($this->getTemplateKey($childKey));
				if (isset($this->tagStruct[$childKey])) {
					$tmplArr = $this->tagStruct[$childKey];
					$templateKeys = array_merge($templateKeys, $tmplArr);
				}
				
				foreach ($templateKeys as $templateKey) {
					$iSubTemplate = $this->getSubTemplate($template, $templateKey);
					$subpartArray[$templateKey] = $this->fillSubpart($iSubTemplate, $objectArr, $templateKey);
				}
			} else {
				$subpartArray[$this->getTemplateKey($childKey)] = '';
			}
		}
		
		$fSubpartArray = array_merge($subpartArray, $glSubpartArrray);
		return $this->substituteMarkerArrayCached($template, $markerArray, $fSubpartArray);
	}
	
	/**
	 * Fill a subpart calling recursivly displayXmlelObject(...).
	 * 
	 * @param $iSubTemplate: The template to fill
	 * @param $objectArr: An array with xmlel objects
	 * @param $templateKey: not used
	 * @return	The filled subpart
	 */
	protected function fillSubpart($iSubTemplate, $objectArr, $templateKey) {
		$content = '';
		
		foreach ($objectArr as $object) {
			$content .= $this->displayXmlelObject($iSubTemplate, $object);
		}
		
		return $content;
	}
		
	/**
	 * Get the template markers for an object with those from the 
	 * tx_musicview_pi1 class.
	 * 
	 * @param	xmlel_base	$xmlel_obj: The object to get the template markers
	 * @return	An array with template markers
	 */
	protected function getTemplateMarkers($xmlel_obj) {
		$objMarkerArray = $xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$tmplMarkerArray = $this->tx_musicview_pi1->getTemplateMarker();
		
		return array_merge($objMarkerArray, $tmplMarkerArray);
	}
	
	/**
	 * Create a template content marker for a child.
	 * 
	 *  @param 	string	$childKey: The child which we create the marker for
	 *  @return	The marker for the child.
	 */
	protected function getTemplateKey($childKey) {
		static $tmplBase = '###TEMPLATE_%s###';
		
		return sprintf($tmplBase, strtoupper($childKey));
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
		$template['total'] = $this->tx_musicview_pi1->cObj->getSubpart($this->tx_musicview_pi1->templateCode, $total);
	 
		for ($i = 0; $i < count($items); $i++) {
			$template['item' . $i] = $this->tx_musicview_pi1->cObj->getSubpart($template['total'], $items[$i]);
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
		return $this->tx_musicview_pi1->cObj->getSubpart($template, $subpart);
	}

	/**
	 * This method calls the substituteMarkerArrayCached method from the plugin's cObj.
	 *
	 * @param 	mixed	$template: The template 
	 * @param	array	$marks: The template markers
	 * @param	array	$subpartArray: The subparts of the template
	 * @return	The filled template
	 */
	protected function substituteMarkerArrayCached($template, $marks = array(), $subpartArray = array()) {
		return $this->tx_musicview_pi1->cObj->substituteMarkerArrayCached($template, $marks, $subpartArray);
	}
	
	/**
	 * Return the method to display.
	 * 
	 * @return	The method to display
	 */
	protected function getApiMethod() {
		return $this->xmlel_obj->getApiMethod();
	}
	
	/**
	 * Get a language text.
	 * 
	 * @param	string	$text: The key
	 * @return 	The text identified by the key
	 */
	protected function getLL($text) {
		return $this->tx_musicview_pi1->pi_getLL($text);
	}
	
	/**
	 * Randomize an array.
	 *
	 * @param	array	$array: The array to randomize
	 * @param	int	$limit: The limit for elements in the result array
	 * @return	The randomized array
	 */
	protected function randomize($array, $limit) {
		if (is_array($array)) {
			$randKeys = array_rand($array, $limit);
	
			$resArray = array();
			foreach ($randKeys as $index) {
				array_push($resArray, $array[$index]);
			}
	
			return $resArray;
		}
		return NULL;
	}

	/**
	 * This method can be used to get the maximum playcount value
	 * from an array of xmlel objects which have the value playcount.
	 * For all other elements this method will generate an error!
	 *
	 * @param	array 	$array: The array with xmlel objects
	 * @param 	string	$value: The value to compare for max value
	 * @return 	The maximum playcount value
	 */
	protected function getMaxPlaycount($array, $value = 'playcount') {
		$max = 0;
		if (is_array($array)) {
			foreach ($array as $xmlel_obj) {
				$tmp = $xmlel_obj->getValue($value);
				if ($tmp > $max) 
					$max = $tmp;
			}
		}
		return $max;
	}

	/**
	 * Returns the classes array set in the API function's
	 * configuration. This method makes only sense for methods
	 * with the classes typoscript option avaiable.
	 *
	 * @return 	The classes array from the typoscript configuration
	 */
	protected function getClasses() {
		$classes = $this->conf['classes.'];
		$a = array();
		if (is_array($classes)) {
			foreach ($classes as $class) 
				array_push($a, $class);
		}
		return $a;
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
	
	/**
	 * This functions sets the templateCode attribute. If the templateCode is set
	 * correct and it's a file the function returns true, else false.
	 * 
	 * @param 	array 	$conf: The configuration for the extension
	 * @return 	true if the templateCode is set correcty
	 */
	private function setTemplate($conf) {
		$this->tx_musicview_pi1->templateCode = $this->tx_musicview_pi1->cObj->fileResource($conf['templateFile']);
 
		return !is_null($this->tx_musicview_pi1->templateCode);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl.php']);
}
?>
