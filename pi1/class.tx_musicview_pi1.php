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
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author	Christoph Gostner <christoph.gostner@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_musicview
 */
class tx_musicview_pi1 extends tx_musicview_base {
	
	/**
	 * Same as class name
	 * 
	 * @var string
	 */
	var $prefixId      = 'tx_musicview_pi1';
	/**
	 * Path to this script relative to the extension dir
	 * 
	 * @var string
	 */
	var $scriptRelPath = 'pi1/class.tx_musicview_pi1.php';


	/**
	 * The main method of the PlugIn
	 *
	 * @param string $content The PlugIn content
	 * @param array $conf The PlugIn configuration
	 * @return The content that is displayed on the website
	 * @author Christoph Gostner
	 */
	function main($content,$conf)	{
		$this->init($conf);

		$method = $this->getFlexFormValue('sDEF', 'apifunc_setting');
		$dom = $this->doRequest($method);

		return $this->workOnRequestResult($dom, $method);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/class.tx_musicview_pi1.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/class.tx_musicview_pi1.php']);
}

?>
