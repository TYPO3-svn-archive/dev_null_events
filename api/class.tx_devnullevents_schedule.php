<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Wolfgang Rotschek
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
* Class with helper functions used in various places within this
* extension. It is encouraged to use these functions in extensions
* of this extension as well!
*
* Note: Some functions cannot be used under FE-conditions. Please
* refer to the documentation of the functions.
*
*
*
*/
class tx_devnullevents_schedule {

	function label_userFunc(&$params, $pObj) {

		$record = t3lib_BEfunc::getRecord($params['table'], $params['row']['uid']);

		$params['title'] = tx_devnullevents_schedule::getLabel($params['row']['uid'], $record);
    }
	
	function getLabel($id, $record) {

		if(empty($record['sh_startdate']) || empty($record['title']))
			return 'new Schedule';
		else 
			return date('Y-m-d', $record['sh_startdate']) . ' ' . $record['title'];
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/api/class.tx_devnullevents_schedule.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/api/class.tx_devnullevents_schedule.php']);
}

?>
