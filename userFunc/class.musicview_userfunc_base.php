<?php

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
abstract class musicview_userfunc_base {

	protected $xmlel_obj;
	protected $tx_musicview_pi1;
	protected $conf;

	/**
	 * Sets some attributes so that they are class-width avaiable for the 
	 * subclasses methods.
	 *
	 * @param	object 	$xmlel_obj: The object with the content to display
	 * @param 	object 	$tx_musicview_pi1: The reference to the plugin's class
	 */
	protected function init($xmlel_obj, $tx_musicview_pi1) {
		$this->xmlel_obj = $xmlel_obj;
		$this->tx_musicview_pi1 = $tx_musicview_pi1;

		$this->setConf();
	}
	
	/**
	 * Set the typoscript configuration.
	 */
	protected function setConf() {
		$className = $this->getClassName();
		$method = str_replace('_', '.', $className);

		$this->conf = $this->getConf($method);
	}

	/**
	 * This method does some inititialisation work and checks if the 
	 * configuration is correct and the template file for the object
	 * is set. If everythink is ok, it calls the fillTemplate method,
	 * so the subclasses only have to fill the template and don't must
	 * worry about everything else.
	 *
	 * @param 	object	$xmlel_base: Base object to display
	 * @param	object	$tx_musicview_pi1: Reference to the plugin
	 * @return 	The content to display.
	 */
	public function userFuncIniTest($xmlel_base, $tx_musicview_pi1) {
		$this->init($xmlel_base, $tx_musicview_pi1);
 
		if (!is_array($this->conf)) {
			return $this->getConfNotFoundError();
		}       
 
		if (!$this->setTemplate($this->conf)) {
			return $this->getTemplateNotFoundError();
		}       
 
		return $this->fillTemplate($conf);
	}
	
	/**
	 * Abstract method subclasses must implement.
	 */
	protected abstract function fillTemplate();

	/**
	 * This function gets template suparts out of the main template. 
	 * The parameter $total declears the template part to select, the items
	 * declear subparts of the main template code.
	 *
	 * @param 	string	$total: The main template part.
	 * @param 	array 	$items: The subparts to select.
	 * @return  	The template and subparts in one array.
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
	 * Get the translation text from the locallang.xml file by the given key.
	 *
	 * @param	string	$key: The key to use
	 * @return	The text
	 */
	protected function getLL($key) {
		return $this->tx_musicview_pi1->pi_getLL($key);
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

	/**
	 * This function gets the language code from the translation file and returns it 
	 * so that the user in the front end sees, that the templateCode wasn't set 
	 * correctly in the extension's configuration.
	 *
	 * @return 	The error message, that the template wasn't found
	 */
	private function getTemplateNotFoundError() {
		return $this->tx_musicview_pi1->pi_getLL('tx_musicview_pi1_template_not_found');
	}

	/**
	 * Call this function if the configuration array of the xml sub object can't
	 * be found.
	 *
	 * @return 	The error message, when the configuration array is invalid
	 */
	private function getConfNotFoundError() {
		return $this->tx_musicview_pi1->pi_getLL('tx_musicview_pi1_conf_not_found');
	}

	/**
	 * Get the configuration of a request method.
	 *
	 * @param	string		$method: The request method
	 * @return 	The configuration of the '$name' object
	 */
	private function getConf($method) {
		return $this->tx_musicview_pi1->getRequestConf($method);
	}

	/**
	 * Get the class name.
	 *
	 * @return 	The class name
	 */
	public function getClassName() {
		return get_class($this);
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
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.musicview_userfunc_base.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.musicview_userfunc_base.php']);
}
?>
