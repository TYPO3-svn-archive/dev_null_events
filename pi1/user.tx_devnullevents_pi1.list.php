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
 class user_devnullevents_pi1_list {

	private $piObj;
	private $cObj;
	private $conf;
	private $lConf;
	
	/**
	 * The main method of the Plugin.
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string The content that is displayed on the website
	 */
	public function render(&$piObj) {

		$this->piObj = $piObj;
		$this->cObj = $piObj->cObj;
		$this->conf = $piObj->conf;
		$this->lConf = $piObj->lConf;
		
		// return t3lib_utility_Debug::viewArray($this->lConf);

		$calendarCatMode	= $this->piObj->pi_getFFvalue($this->cObj->data['pi_flexform'], 'eventsCatMode', 'sList');
		$calendarCatList	= $this->piObj->pi_getFFvalue($this->cObj->data['pi_flexform'], 'eventsCatList', 'sList');
		
		$countMax			= $this->lConf['sList.maxEvents'];
		if($countMax == 0)
			$countMax = $this->conf['eventList.']['maxEvents'];
		
		$singleView			= $this->lConf['sDEF.singleView'];
		if($singleView == 0)
			$singleView = $this->conf['eventList.']['pidSingleView'];
		
		$textNoEvents		= $this->lConf['sText.textNoEvents'];
		if($textNoEvents == 0)
			$textNoEvents = $this->conf['eventList.']['eventTextNoEvents'];
		
		$textNoMoreEvents	= $this->lConf['sText.textLessEvents'];
		if($textNoMoreEvents == 0)
			$textNoMoreEvents = $this->conf['eventList.']['eventTextNoMoreEvents'];
		
		$textMoreEvents		= $this->lConf['sText.textMoreEvents'];
		if($textMoreEvents == 0)
			$textMoreEvents = $this->conf['eventList.']['eventTextMoreEvents'];
		
		
		// load additional css
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['events.']['cssScreen'], 'stylesheet', 'all');

		// $content = t3lib_utility_Debug::viewArray($this->cObj->data);

		// Prepare select clause for tx_devnullevents_event list
		$dbEventFields = array(
			'tx_devnullevents_event.uid as ev_uid',
			'tx_devnullevents_event.title as ev_title',
			'(select min(tx_devnullevents_schedule.sh_startdate)
			from tx_devnullevents_schedule
			where tx_devnullevents_schedule.parentid=tx_devnullevents_event.uid
				and tx_devnullevents_schedule.hidden=0
				and tx_devnullevents_schedule.deleted=0)
			as ev_startdate',
			'location',
			'organizer',
			'instructor'
			);

		$dbEventTables = array(
			'tx_devnullevents_event
			left join tx_devnullevents_event_cat_mm
				on tx_devnullevents_event.uid = tx_devnullevents_event_cat_mm.uid_local
			inner join tx_devnullevents_cat
				on tx_devnullevents_event_cat_mm.uid_foreign = tx_devnullevents_cat.uid
				and tx_devnullevents_cat.hidden=0 and tx_devnullevents_cat.deleted=0',
		);

		$dbEventClause = array(
			'tx_devnullevents_event.deleted=0',
			'tx_devnullevents_event.hidden=0',
			'(select min(tx_devnullevents_schedule.sh_startdate)
			from tx_devnullevents_schedule
			where tx_devnullevents_schedule.parentid=tx_devnullevents_event.uid
				and tx_devnullevents_schedule.hidden=0
				and tx_devnullevents_schedule.deleted=0) >= ' . mktime(0,0,0),
		);
		
		if($calendarCatMode == 1) {
			$dbEventClause[] = 'tx_devnullevents_event_cat_mm.uid_foreign IN (' . $calendarCatList .')';
		}

		// Prepare select statement for tx_devnullevents_schedule list
		$dbSchedFields = array(
			'tx_devnullevents_schedule.uid as sh_uid',
			'tx_devnullevents_schedule.title as sh_title',
			'tx_devnullevents_schedule.sh_startdate',
			'tx_devnullevents_schedule.sh_starttime',
			'if(sh_enddate=0, sh_startdate, sh_enddate) as sh_enddate',
			'tx_devnullevents_schedule.sh_endtime',
			'tx_devnullevents_schedule.fullday',
			'tx_devnullevents_text.descr'
		);
		
		$dbSchedTables = array(
			'tx_devnullevents_schedule left join tx_devnullevents_text on tx_devnullevents_schedule.descr=tx_devnullevents_text.uid',
		);
		
		$dbSchedClause = array(
			'tx_devnullevents_schedule.parentid = :uid',
			'tx_devnullevents_schedule.hidden=0',
			'tx_devnullevents_schedule.deleted=0',
		);
		
		$sqlSchedule = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			implode(',',     $dbSchedFields),
			implode(',',     $dbSchedTables),
			implode(' AND ', $dbSchedClause),
			'',
			'sh_startdate'
		);
		
		// Prepare select statement for tx_devnullevents_partner list
		$dbPartnerFields = array(
			'tx_devnulladdr_address.*',
		);
		
		$dbPartnerTables = array(
			'tx_devnullevents_event_partner_mm inner join tx_devnulladdr_address
				on tx_devnulladdr_address.uid=tx_devnullevents_event_partner_mm.uid_foreign
				and tx_devnullevents_event_partner_mm.linkjoin=:join',
		);
		
		$dbPartnerClause = array(
			'tx_devnullevents_event_partner_mm.uid_local = :uid',
			'tx_devnulladdr_address.hidden=0',
			'tx_devnulladdr_address.deleted=0',
		);

		$sqlPartner = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			implode(',',     $dbPartnerFields), 
			implode(',',     $dbPartnerTables), 
			implode(' AND ', $dbPartnerClause),
			'',
			''
		);
		
		// Prepare select statement for tx_devnullevents_text entries
		$sqlText = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			'*', 'tx_devnullevents_text', 'uid=:uid', '', ''); 
		
		// execute SQL-select for tx_devnullevents_event
		$sqlEvent = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'distinct ' . implode(',',     $dbEventFields), 
			implode(',',     $dbEventTables), 
			implode(' AND ', $dbEventClause),
			'',
			'ev_startdate'
		);
		
		$templateCode = $piObj->cObj->fileResource($piObj->conf['eventList.']['template']);
		
		$subParts['content'] 		= $piObj->cObj->getSubpart($templateCode, '###EVENT_CONTENT###');	// main container
		$subParts['event']			= $piObj->cObj->getSubpart($templateCode, '###EVENT_ENTRY###');		// one event entry
		$subParts['organizer']		= $piObj->cObj->getSubpart($templateCode, '###ORGANIZER_ENTRY###');
		$subParts['location']		= $piObj->cObj->getSubpart($templateCode, '###LOCATION_ENTRY###');
		$subParts['instrList']		= $piObj->cObj->getSubpart($templateCode, '###INSTRUCTOR_LIST###');
		$subParts['scheduleList']	= $piObj->cObj->getSubpart($templateCode, '###SCHEDULE_LIST###');
		
		// walk through tx_devnullevents_event
		$countEvents = 0;
		
		// $content .= t3lib_utility_Debug::viewArray($dbEventClause);

		while(($rowEvent = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sqlEvent)) && ($countEvents < $countMax || $countMax == 0)){

			// $content .= t3lib_utility_Debug::viewArray($rowEvent);
			
			$conf = array(
				'parameter' => $singleView,
				'returnLast' => 'url',
				'additionalParams' => '&tx_devnullevents[event]=' . $rowEvent['ev_uid'],
				'useCacheHash' => 1,
			);
			$link = $piObj->cObj->typoLink('', $conf);
			// $link = t3lib_div::locationHeaderUrl($link);

			// $content .= t3lib_utility_Debug::viewArray($conf);

			$marker = array(
				'###EVENT_STARTDATE###' => date('d-m-Y', $rowEvent['ev_startdate']),
				'###EVENT_TITLE###' => $rowEvent['ev_title'],
				'###EVENT_LINK_URL###' => $link,
				'###EVENT_CONTENT###' => '',
			);

			if($rowEvent['organizer']) {
				$sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.org'));
				$rowOrg = $sqlPartner->fetch();
				if($rowOrg) {
					$marker['###EVENT_CONTENT###'] .= $this->getOrganizerContent($subParts['organizer'], $rowOrg);
				}
				$sqlPartner->free();
			}

			if($rowEvent['location']) {
				$sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.loc'));
				$rowOrg = $sqlPartner->fetch();
				if($rowOrg) {
					$marker['###EVENT_CONTENT###'] .= $this->getLocationContent($subParts['location'], $rowOrg);
				}
				$sqlPartner->free();
			}

			if($rowEvent['instructor']) {
				$sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.instr'));
				$rowOrg = $sqlPartner->fetchAll();
				if($rowOrg) {
					$marker['###EVENT_CONTENT###'] .= $this->getInstrContent($subParts['instrList'], $rowOrg);
				}
				$sqlPartner->free();
			}

			$marker['###EVENT_CONTENT###'] = $this->cObj->stdWrap(
				$marker['###EVENT_CONTENT###'], 
				$this->conf['eventList.']['eventContent_stdWrap.']
			);

			// fetch schedules
			$sqlSchedule->execute(array(':uid'=> $rowEvent['ev_uid']));
			$rowSchedule = $sqlSchedule->fetchAll();
			if($rowSchedule) {
				$marker['###EVENT_CONTENT###'] .= $this->getScheduleListContent($subParts['scheduleList'], $rowSchedule);
			}
			$sqlSchedule->free();

			$content .= $piObj->cObj->substituteMarkerArray($subParts['event'], $marker);
			
			$countEvents++;
		}
		
		if($countEvents == 0) {
			$sqlText->execute(array(':uid'=>$textNoEvents));
			$rowText = $sqlText->fetch();
			if($rowText) {
				$content .= $this->piObj->pi_RTEcssText($rowText['descr']);
			}
			$sqlText->free();
		}
		else if ($GLOBALS['TYPO3_DB']->sql_fetch_assoc($sqlEvent)) {
			// check for more events
			$sqlText->execute(array(':uid'=>$textMoreEvents));
			$rowText = $sqlText->fetch();
			if($rowText) {
				$content .= $this->piObj->pi_RTEcssText($rowText['descr']);
			}
			$sqlText->free();
		}
		else if ($textNoMoreEvents) {
			$sqlText->execute(array(':uid'=>$textNoMoreEvents));
			$rowText = $sqlText->fetch();
			if($rowText) {
				$content .= $this->piObj->pi_RTEcssText($rowText['descr']);
			}
			$sqlText->free();
		}
		
		return $this->piObj->cObj->substituteMarkerArray($subParts['content'], array('###EVENT_LIST###'=>$content));
	}
	
	function getOrganizerContent($template, $rowOrg)
	{
		$marker = array(
			'###ORGANIZER_LABEL###' => $rowOrg['label'],
		);
		
		return $this->piObj->cObj->substituteMarkerArray($template, $marker);
	}

	function getLocationContent($template, $rowOrg)
	{
		$marker = array(
			'###LOCATION_LABEL###' => $rowOrg['label'],
		);
		
		return $this->piObj->cObj->substituteMarkerArray($template, $marker);
	}

	function getInstrContent($template, $rowOrg)
	{
		$templateEntry = $this->piObj->cObj->getSubpart($template, '###INSTRUCTOR_ENTRY###');

		$entries = array();
		
		foreach($rowOrg as $row) {
			$marker = array(
				'###FIRST_NAME###' => $row['first_name'],
			);
			$entries[] = $this->piObj->cObj->substituteMarkerArray($templateEntry, $marker);
		}
		
		return $this->piObj->cObj->substituteSubpart($template, '###INSTRUCTOR_ENTRY###', implode(PHP_EOL, $entries));
		
	}

	function getScheduleListContent($template, $rowSchedule)
	{
		$templateEntry = $this->piObj->cObj->getSubpart($template, '###SCHEDULE_ENTRY###');

		$entries = array();
		
		foreach($rowSchedule as $row) {
			$marker = array();
			
			if($row['fullday'] && ($row['sh_startdate'] == $row['sh_enddate'])) {
				$marker['###SCHEDULE_SCHEDULE###'] = date('d-m', $row['sh_startdate']);
			}
			else if($row['fullday']) {
				$marker['###SCHEDULE_SCHEDULE###'] = date('d-m', $row['sh_startdate']) . ' - ' . date('d-m', $row['sh_enddate']);
			}
			else if($row['sh_startdate'] == $row['sh_enddate']) {
				$marker['###SCHEDULE_SCHEDULE###'] = date('d-m', $row['sh_startdate']) . gmdate(' H:i', $row['sh_starttime']) . ' - ' . gmdate('H:i', $row['sh_endtime']);
			}
			else {
				$marker['###SCHEDULE_SCHEDULE###'] = date('d-m', $row['sh_startdate']) . gmdate(' H:i', $row['sh_starttime']) . ' - ' . date('d-m ', $row['sh_enddate']) . gmdate('H:i', $row['sh_endtime']);
			}

			$marker['###SCHEDULE_TITLE###'] = $row['sh_title'];

			$entries[] = $this->piObj->cObj->substituteMarkerArray($templateEntry, $marker);
		}
		
		return $this->piObj->cObj->substituteSubpart($template, '###SCHEDULE_ENTRY###', implode(PHP_EOL, $entries));
		
	}
}

?>