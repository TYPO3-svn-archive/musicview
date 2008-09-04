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
	 * The child key for the items to display
	 */
	protected $childKey = 'tag';
	/**
	 * The name of the subpart in the template file
	 */
	protected $templateSubpartName = '###TEMPLATE_TAG###';
	
	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$method = $this->getMethodName();

		$template = $this->getTemplateParts('###TEMPLATE###', array($this->templateSubpartName));
		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray[$this->templateSubpartName] = $this->displayTags($template['item0'], $this->xmlel_obj->getChild($this->childKey));

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	/**
	 * Fill the template with the objects
	 *
	 * @param	mixed	$template: The template to fill
	 * @param	array	$objectArr: The object to fill in the template
	 * @return	The filled template
	 */
	protected function displayTags($template, $objectArr) {
		$content = '';

		foreach ($objectArr as $object) {
			$markerArray = $object->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
		}
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.tag_getSimilar.php']);
}
?>
