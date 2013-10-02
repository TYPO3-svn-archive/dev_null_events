<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 W. Rotschek <typo3@dev-null.at>
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
 * Class with methods called as hooks from TCE Main
 *
 * @author	W. Rotschek <typo3@dev-null.at>
 * @package	TYPO3
 * @subpackage	tx_devnullevents
 */
class tx_devnullevents_tcemainprocdm {

	/**
	 * This method is called when the 'processDatamap'-hooks are acivated in ext_localconf.php.
	 * It is called in tcemain right before the database operations (INSERT/UPDATE) are
	 * carried out.
	 *
	 * The following tasks are accomplished
	 * - Create/Change label fields for tx_devnullevents_event
	 *
	 * @param	string		$status: The status of the current record
	 * @param	string		$table: The table of the current record
	 * @param	string		$id: The current record UID
	 * @param	array		$fieldArray: The currently processed fieldArray, passed by reference
	 * @param	string		$thisRef: The current cObj, passed by reference
	 * @return	void		Nothing returned. The fieldArray is directly changed, as it is passed by reference
	 */
	function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$thisRef) {

		// ********************************************************************
		// LABELS FOR partner
		// ********************************************************************

		if ($table == 'tx_devnullevents_event') {
			$label = tx_devnullevents_event::tca_getLabel($id, $thisRef->datamap['tx_devnullevents_event'][$id], $thisRef->datamap);
			// false if hidden/unhidden in backend recordlist
			if($label)
				$fieldArray['label'] = $label;
		}

	}


	/**
	 * This method is called when the 'processDatamap'-hooks are acivated in ext_localconf.php.
	 * It is called in tcemain right AFTER the database operations (INSERT/UPDATE) are
	 * carried out.
	 *
	 * The following tasks are accomplished
	 *
	 * @param	string		$status: The status of the current record
	 * @param	string		$table: The table of the current record
	 * @param	string		$id: The current record UID
	 * @param	array		$fieldArray: The currently processed fieldArray, passed by reference
	 * @param	string		$thisRef: The current cObj, passed by reference
	 * @return	void		Nothing returned. The method directly makes the necessary db-updates if possible.
	 */
	function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, &$thisRef) {


	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/inc/class.tx_devnullevents_tcemainprocdm.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dev_null_events/inc/class.tx_devnullevents_tcemainprocdm.php']);
}

?>