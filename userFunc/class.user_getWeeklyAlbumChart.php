<?php

require_once (t3lib_extMgm::extPath('musicview').'userFunc/class.musicview_userfunc_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class user_getWeeklyAlbumChart extends musicview_userfunc_base {

	/**
	 * The name of the template's subpart to fill
	 */
	protected $subTemplateName = '###TEMPLATE_ALBUM###';
	/**
	 * The name of the xmlel_objects child to display
	 */
	protected $xmlelSubobjectName = 'album';
	/**
	 * The template marker's name for the class
	 */
	protected $templateMarkerChartClass = '###TEMPLATE_ALBUM_user.getWeeklyAlbumChart_TR_CLASS###';
	/**
	 * The template marker's name for the width
	 */
	protected $templateMarkerChartWidth = '###TEMPLATE_ALBUM_user.getWeeklyAlbumChart_DIV_WIDTH###';
	/**
	 * The property to filter the width
	 */
	protected $subobjectValue = 'playcount';

	/**
	 * Start filling the template. You have to implement this method when
	 * the userFunc class extends 'musicview_userfunc_base'.
	 *
	 * @return 	The content of the xmlel_obj from the 'musicview_userfunc_base' class
	 */
	protected function fillTemplate() {
		$template = $this->getTemplateParts('###TEMPLATE###', array($this->subTemplateName));

		$markerArray = $this->xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
		$subpartArray[$this->subTemplateName] = $this->displaySubObject($template['item0'], $this->xmlel_obj->getChild($this->xmlelSubobjectName));

		return $this->substituteMarkerArrayCached($template['total'], $markerArray, $subpartArray);
	}

	/**
	 * Get the albums content.
	 *
	 * @param 	mixed 	$template: The template
	 * @param	array	$arr_xmlel: The albums to display
	 * @return 	The content
	 */
	protected function displaySubobject($template, $arr_xmlel) {
		$content = '';
		$max = $this->getMaxPlaycount($arr_xmlel, $this->subobjectValue);
		$cut = $this->conf['cut'];
		$percentage = $this->conf['percentage'];
		$classes = $this->getClasses();
		$count = 0;

		foreach ($arr_xmlel as $xmlel_obj) {
			$playcount = $xmlel_obj->getValue($this->subobjectValue);
			$per = intval(($playcount * 100) / $max);

			if ($cut && $per == $percentage) {
				break;
			}

			$markerArray = $xmlel_obj->getTemplateMarkers($this->tx_musicview_pi1->cObj, $this->conf);
			$markerArray[$this->templateMarkerChartClass] = $classes[$count%2];
			$markerArray[$this->templateMarkerChartWidth] =  $per;
			$content .= $this->substituteMarkerArrayCached($template, $markerArray);
			$count++;
		}
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyAlbumChart.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/userFunc/class.user_getWeeklyAlbumChart.php']);
}

?>
