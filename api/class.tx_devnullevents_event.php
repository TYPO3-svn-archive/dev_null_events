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
class tx_devnullevents_event {

	function label_userFunc(&$params, $pObj) {
   
		$record = t3lib_BEfunc::getRecord($params['table'], $params['row']['uid']);
		$params['title'] = tx_devnullevents_event::getLabel($params['row']['uid'], $record);
    }
	 
	function getLabel($id, $record) {
   
		// prepare SQL-statement to fetch tx_devnullevents_schedule records
		$sqlSchedule = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			'sh_startdate',
			'tx_devnullevents_schedule',
			'parentid=:uid AND deleted=0 AND hidden=0',
			'',
			'sh_startdate',
			'1');

		if ($sqlSchedule) {
			$sqlSchedule->execute(array(':uid'=>$uid));
			$shRow = $sqlSchedule->fetch();
		}

		// release sql statement
		$sqlSchedule->free();
		
		if (is_array($shRow)) {
			return date('Y-m-d', $shRow['sh_startdate']) . ' ' . $record['title'];
		} else {		
			return $record['title'];
		}
     }

	function tca_getLabel($id, $record, $datamap) {

		// empty if record gets hidden/unhidden in backend recordlist
		$sched = $datamap['tx_devnullevents_schedule'];
		if(empty($sched))
			return false;

		$dt = 0;

			// for each nested schedule
		foreach($sched as $shUid => $shRow)
		{
			$shHidden	= 0;
			$shDate		= 0;
			
			// unchanged record does not hold a sh_datestart
			// fetch it from the database
			if(empty($shRow['sh_startdate'])) {
				$beRow = t3lib_BEfunc::getRecord('tx_devnullevents_schedule', $shUid);
			}

			$shHidden	= array_key_exists('hidden', $shRow)		? $shRow['hidden']			: $beRow['hidden'];
			$shDate		= array_key_exists('sh_startdate', $shRow)	? $shRow['sh_startdate']	: $beRow['sh_startdate'];
			
			// do we have a date - process it
			if($shDate && $shHidden == 0)
				$dt = ($dt == 0 || $dt > $shDate) ? $shDate : $dt;
				
		}

		if ($dt) {
			return date('Y-m-d', $dt) . ' ' . $record['title'];
		} else {		
			return $record['title'];
		}
     }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/api/class.tx_devnullevents_event.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/api/class.tx_devnullevents_event.php']);
}

?>
