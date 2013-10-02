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
 * Plugin 'dev/null Calendar' for the 'dev_null_events' extension.
 *
 * @author	W. Rotschek <typo3@dev-null.at>
 * @package	TYPO3
 * @subpackage	tx_devnullevents
 */
class tx_devnullevents_json extends tslib_pibase {
	public $prefixId      = 'tx_devnullevents';
	public $scriptRelPath = 'json/class.tx_devnullevents_json.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'dev_null_events';						// The extension key.
	public $pi_checkCHash = FALSE;
	
	private $lConf = array();
	
	/**
	 * The main method of the Plugin.
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string The content that is displayed on the website
	 */
	public function main($content, array $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj=1;
		
		// return t3lib_utility_Debug::viewArray($this->piVars);

		// init Flexform values
		$this->init();
		
		$selFields = implode(', ', array(
			'tx_devnullevents_event.uid as ev_uid',
			'tx_devnullevents_event.title as ev_title',
			'tx_devnullevents_schedule.uid as sh_uid',
			'tx_devnullevents_schedule.title as sh_title',
			'tx_devnullevents_schedule.sh_startdate',
			'tx_devnullevents_schedule.sh_starttime',
			'if(sh_enddate=0, sh_startdate, sh_enddate) as sh_enddate',
			'tx_devnullevents_schedule.sh_endtime',
			'tx_devnullevents_schedule.fullday',
			'tx_devnullevents_event.colorbkg as ev_colorbkg',
			'tx_devnullevents_event.colortxt as ev_colortxt',
			'tx_devnullevents_schedule.colorbkg as sh_colorbkg',
			'tx_devnullevents_schedule.colortxt as sh_colortxt',
		));

		$selTables = implode(', ', array(
			'tx_devnullevents_event',
			'tx_devnullevents_schedule',
		));
	
		$selClause = implode(' AND ', array(
			'tx_devnullevents_event.uid=tx_devnullevents_schedule.parentid',
			'tx_devnullevents_event.deleted=0',
			'tx_devnullevents_event.hidden=0',
			'tx_devnullevents_schedule.deleted=0',
			'tx_devnullevents_schedule.hidden=0',
//			'sh_startdate in (' . $this->piVars['start'] .','. $this->piVars['end'] . ')',
		));
		
		$dbRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($selFields, $selTables, $selClause);
		
		$json = array();

		$selSchedFields = implode(', ', array(
			'tx_devnullevents_schedule.title as sh_title',
			'tx_devnullevents_schedule.sh_startdate',
			'tx_devnullevents_schedule.sh_starttime',
			'if(sh_enddate=0, sh_startdate, sh_enddate) as sh_enddate',
			'tx_devnullevents_schedule.sh_endtime',
			'tx_devnullevents_schedule.fullday',
		));

		$sqlSchedClause = implode(' AND ', array(
			'deleted=0',
			'hidden=0',
			'parentid=:uid',
		));
		
		$sqlSchedules = $GLOBALS['TYPO3_DB']->prepare_SELECTquery($selSchedFields, 'tx_devnullevents_schedule', $sqlSchedClause);
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($dbRes)){
			$sqlSchedules->execute(array(':uid'=>$row['ev_uid']));
			
			$conf = array(
				'parameter' => $this->lConf['sDEF.singleView'],
				'returnLast' => 'url',
				'additionalParams' => '&tx_devnullevents[event]=' . $row['ev_uid'],
				'useCacheHash' => 1,
			);
			$link = $this->cObj->typoLink('', $conf);
			$link = t3lib_div::locationHeaderUrl($link);

			if($row['sh_enddate'] == 0)
				$row['sh_enddate'] = $row['sh_startdate'];
			
			$a = array(
				'id' 	=> $row['sh_uid'],
				'title' => $row['ev_title'],
				'start' => $row['fullday'] ? date('Y-m-d', $row['sh_startdate']) : date('Y-m-d', $row['sh_startdate']) . gmdate(' H:i', $row['sh_starttime']),
				'end' 	=> $row['fullday'] ? date('Y-m-d', $row['sh_enddate'])   : date('Y-m-d', $row['sh_enddate']) . gmdate(' H:i', $row['sh_endtime']),
				'allDay' => $row['fullday'] ? 1 : 0,
				'url'	=> $link,
			);
			
			while($rowSched = $sqlSchedules->fetch()) {
				if($rowSched['fullday'] && ($rowSched['sh_startdate'] == $rowSched['sh_enddate'])) {
					$_r= date('d-m', $rowSched['sh_startdate']);
				}
				else if($rowSched['fullday']) {
					$_r = date('d-m', $rowSched['sh_startdate']) . ' - ' . date('d-m', $rowSched['sh_enddate']);
				}
				else if($rowSched['sh_startdate'] == $rowSched['sh_enddate']) {
					$_r = date('d-m', $rowSched['sh_startdate']) . gmdate(' H:i', $rowSched['sh_starttime']) . ' - ' . gmdate('H:i', $rowSched['sh_endtime']);
				}
				else {
					$_r = date('d-m', $rowSched['sh_startdate']) . gmdate(' H:i', $rowSched['sh_starttime']) . ' - ' . date('d-m ', $rowSched['sh_enddate']) . gmdate('H:i', $rowSched['sh_endtime']);
				}
				$a['qtipRows'][] = $_r . ' ' . $rowSched['sh_title'];
			}
			
			$a['qtipDescr'] = implode('<br />', $a['qtipRows']);
			unset($a['qtipRows']);
			
			if($row['ev_colorbkg'] || $row['sh_colorbkg'])
				$a['color'] = $row['sh_colorbkg'] ? $row['sh_colorbkg'] : $row['ev_colorbkg'];
			if($row['ev_colortxt'] || $row['sh_colortxt'])
				$a['textColor'] = $row['sh_colortxt'] ? $row['sh_colortxt'] : $row['ev_colortxt'];
			
			$json[] = $a;
		}

		return json_encode($json);
	}
	
	/**
	 * initializes the flexform and all config options
	 */
	private function init(){
	
		 // Init and get the flexform data of the plugin
		$this->pi_initPIflexForm();
		
		// Assign the flexform data to a local variable for easier access
		$piFlexForm = $this->cObj->data['pi_flexform'];

		// Traverse the entire array based on the language...
		// and assign each configuration option to $this->lConf array...
		foreach ( $piFlexForm['data'] as $sheet => $data ) {
			foreach ( $data as $lang => $value ) {
				foreach ( $value as $key => $val ) {
					$this->lConf[$sheet . '.' . $key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
				}
			}
		}
	}
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/dev_null_events/json/class.tx_devnullevents_json.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/dev_null_events/json/class.tx_devnullevents_json.php']);
}

?>