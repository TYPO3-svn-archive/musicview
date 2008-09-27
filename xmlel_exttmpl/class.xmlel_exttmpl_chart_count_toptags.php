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

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_exttmpl_chart_count_toptags extends xmlel_exttmpl {
	
	/**
	 * The property to filter the width
	 */
	protected $subobjectValue;
	protected $max;
	protected $parentClass;
	protected $childClass;
	protected $childKey;
	
	public function __construct() {
		parent::__construct();
		
		$this->subobjectValue = 'count';
		$this->max = 0;
		$this->parentClass = xmlel_toptags;
		$this->childClass = xmlel_tag;
		$this->childKey = 'tag';
	}
		
	
	protected function getTemplateMarkers($xmlel_obj) {
		$markerArray = parent::getTemplateMarkers($xmlel_obj);
		
		if ($xmlel_obj instanceof $this->parentClass) {
			$arr = $xmlel_obj->getChild($this->childKey);
			$this->max = $this->getMaxPlaycount($arr, $this->subobjectValue);
		}

		if ($xmlel_obj instanceof $this->childClass) {
			static $count = 0;
			$classes = $this->getClasses();
			
			$playcount = $xmlel_obj->getValue($this->subobjectValue);
			if ($this->max == 0) {
				$per = 0;
			} else {
				$per = intval(($playcount * 100) / $this->max);
			}
			
			$markerArray['###TEMPLATE_CHART_TR_CLASS-EFFECT###'] = $classes[$count%2];
			$markerArray['###TEMPLATE_CHART_DIV_WIDTH###'] = $per;
			$count++;	
		}
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl_chart_count_toptags.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel_exttmpl/class.xmlel_exttmpl_chart_count_toptags.php']);
}
?>
