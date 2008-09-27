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

/**
 * UserFunc 'user_musicview_modifyDate' for the 'musicview' extension.
 *
 * @author	Christoph Gostner <christoph.gostner@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_musicview
 */
class user_musicview_modifyDate {
	
	public static $modifyDate = true;
	
	/**
	 * Modify the time, so that it maches the last.fm API requirements.
	 * 
	 * @param int $value The amount of time to modify
	 * @param tx_musicview_base $ref The reference to the base class
	 * @return int The corrected amount of time
	 * @author Christoph Gostner
	 */
	public function format(&$value, &$ref) {
		
		if (self::$modifyDate) {
			return $value+$ref->conf['modifyTime'];
		}
		return $value;
	}
}

?>