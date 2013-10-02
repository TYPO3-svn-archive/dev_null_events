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
class user_devnullevents_pi1_view {

	private $piObj;
	private $cObj;
	private $conf;
	private $piVars;

	private $sqlPartner	= 0;
	private $sqlText 	= 0;
	
	private $subparts = array();
	
	/**
	 * The main method of the Plugin.
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string The content that is displayed on the website
	 */
	public function render(&$piObj) {

		$this->piObj	= $piObj;
		$this->cObj		= $piObj->cObj;
		$this->conf		= $piObj->conf;
		$this->piVars	= $piObj->piVars;
		
		$uidEvent		= $this->piVars['event'];
		
		$pidMonthView = $this->piObj->pi_getFFvalue($this->cObj->data['pi_flexform'], 'monthView', 'sList');
		if($monthView == 0)
			$monthView = $this->conf['eventView.']['pidMonthView'];
		
		$textNotFound = $this->piObj->pi_getFFvalue($this->cObj->data['pi_flexform'], 'textNotFound', 'sList');
		if($textNoEvents == 0)
			$textNoEvents = $this->conf['eventView.']['textNotFound'];
		
		// load additional css
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['events.']['cssScreen'], 'stylesheet', 'all');

		// Prepare select clause for tx_devnullevents_event list
		$dbEventFields = implode(',',array(
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
			'instructor',
			'descr'
			));

		$dbEventClause = implode(' AND ',array(
			'tx_devnullevents_event.deleted=0',
			'tx_devnullevents_event.hidden=0',
			'tx_devnullevents_event.uid=:uid',
		));
		
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

		$this->sqlPartner = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
			implode(',',     $dbPartnerFields), 
			implode(',',     $dbPartnerTables), 
			implode(' AND ', $dbPartnerClause),
			'',
			''
		);
		
		// Prepare select statement for tx_devnullevents_partner list
		$this->sqlText = $GLOBALS['TYPO3_DB']->prepare_SELECTquery('*', 'tx_devnullevents_text', 'uid=:uid');
		
		$sqlEvent = $GLOBALS['TYPO3_DB']->prepare_SELECTquery($dbEventFields, 'tx_devnullevents_event', $dbEventClause);
		$sqlEvent->execute(array(':uid' => $uidEvent));
		
		// only one record
		$rowEvent = $sqlEvent->fetch();
		
		$sqlSched = $GLOBALS['TYPO3_DB']->prepare_SELECTquery('*', 'tx_devnullevents_schedule', 'parentid=:uid AND deleted=0 and hidden=0');
		$sqlSched->execute(array(':uid' => $uidEvent));
		
		// multiple schedules
		$rows['schedule'][] = $sqlSched->fetchAll();
		
		$templateCode = $piObj->cObj->fileResource($piObj->conf['eventView.']['template']);
		
		$this->subParts['content'] 			= $piObj->cObj->getSubpart($templateCode, '###EVENT_CONTAINER###');	// main container
		$this->subParts['organizer']		= $piObj->cObj->getSubpart($templateCode, '###ORGANIZER_ENTRY###');
		$this->subParts['location']			= $piObj->cObj->getSubpart($templateCode, '###LOCATION_ENTRY###');
		$this->subParts['instrList']		= $piObj->cObj->getSubpart($templateCode, '###INSTRUCTOR_LIST###');
		$this->subParts['scheduleList']		= $piObj->cObj->getSubpart($templateCode, '###SCHEDULE_LIST###');
		
		$marker = array(
			'###EVENT_STARTDATE###' => date('d-m-Y', $rowEvent['ev_startdate']),
			'###EVENT_TITLE###' => $rowEvent['ev_title'],
			'###EVENT_LINK_URL###' => $link,
			'###EVENT_CONTENT###' => '',
		);

		if($rowEvent['organizer']) {
			$this->sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.org'));
			$rowOrg = $this->sqlPartner->fetch();
			if($rowOrg) {
				$marker['###EVENT_CONTENT###'] .= $this->getOrganizerContent($this->subParts['organizer'], $rowOrg);
			}
			$this->sqlPartner->free();
		}

		if($rowEvent['location']) {
			$this->sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.loc'));
			$rowOrg = $this->sqlPartner->fetch();
			if($rowOrg) {
				$marker['###EVENT_CONTENT###'] .= $this->getLocationContent($this->subParts['location'], $rowOrg);
			}
			$this->sqlPartner->free();
		}

		if($rowEvent['instructor']) {
			$this->sqlPartner->execute(array(':uid'=>$rowEvent['ev_uid'], ':join'=>'events.instr'));
			$rowOrg = $this->sqlPartner->fetchAll();
			if($rowOrg) {
				$marker['###EVENT_CONTENT###'] .= $this->getInstrContent($this->subParts['instrList'], $rowOrg);
			}
			$this->sqlPartner->free();
		}

		$marker['###EVENT_CONTENT###'] = $this->cObj->stdWrap(
			$marker['###EVENT_CONTENT###'], 
			$this->conf['eventView.']['eventContent_stdWrap.']
		);

		if($rowEvent['descr']) {
			$this->sqlText->execute(array(':uid'=>$rowEvent['descr']));
			$rowText = $this->sqlText->fetch();
			if($rowText) {
				$marker['###EVENT_CONTENT###'] .= $this->cObj->stdWrap(
					$rowText['descr'], $this->conf['eventView.']['eventText_stdWrap.']);
			}
			$this->sqlText->free();
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
			'tx_devnullevents_text.descr',
			'tx_devnullevents_schedule.location',
			'tx_devnullevents_schedule.organizer',
			'tx_devnullevents_schedule.instructor',
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
		
		// fetch schedules
		$sqlSchedule->execute(array(':uid'=> $rowEvent['ev_uid']));
		$rowSchedule = $sqlSchedule->fetchAll();
		if($rowSchedule) {
			$marker['###EVENT_CONTENT###'] .= $this->getScheduleListContent($this->subParts['scheduleList'], $rowSchedule);
		}

		$sqlEvent->free();
		$sqlSched->free();
		
		return $this->piObj->cObj->substituteMarkerArray($this->subParts['content'], $marker);
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
			$marker = array(
				'###SCHEDULE_TITLE###' => $row['sh_title'],
				'###SCHEDULE_CONTENT###' => '',
			);
			
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

			if($row['organizer']) {
				$this->sqlPartner->execute(array(':uid'=>$row['sh_uid'], ':join'=>'schedule.org'));
				$rowOrg = $this->sqlPartner->fetch();
				if($rowOrg) {
					$marker['###SCHEDULE_CONTENT###'] .= $this->getOrganizerContent($this->subParts['organizer'], $rowOrg);
				}
				$this->sqlPartner->free();
			}

			if($row['location']) {
				$this->sqlPartner->execute(array(':uid'=>$row['sh_uid'], ':join'=>'schedule.loc'));
				$rowOrg = $this->sqlPartner->fetch();
				if($rowOrg) {
					$marker['###SCHEDULE_CONTENT###'] .= $this->getLocationContent($this->subParts['location'], $rowOrg);
				}
				$this->sqlPartner->free();
			}

			if($row['instructor']) {
				$this->sqlPartner->execute(array(':uid'=>$row['sh_uid'], ':join'=>'schedule.instr'));
				$rowOrg = $this->sqlPartner->fetchAll();
				if($rowOrg) {
					$marker['###SCHEDULE_CONTENT###'] .= $this->getInstrContent($this->subParts['instrList'], $rowOrg);
				}
				$this->sqlPartner->free();
			}

			$marker['###SCHEDULE_CONTENT###'] = $this->cObj->stdWrap(
				$marker['###SCHEDULE_CONTENT###'], 
				$this->conf['eventView.']['scheduleContent_stdWrap.']
			);

			if($row['descr']) {
				$marker['###SCHEDULE_CONTENT###'] .= $this->cObj->stdWrap(
					$row['descr'], $this->conf['eventView.']['eventText_stdWrap.']);
			}

			$entries[] = $this->piObj->cObj->substituteMarkerArray($templateEntry, $marker);
		}
		
		// $items = implode(PHP_EOL, $entries));
		// return t3lib_utility_Debug::viewArray($items);

		return $this->piObj->cObj->substituteSubpart($template, '###SCHEDULE_ENTRY###', implode(PHP_EOL, $entries));
		
	}
	
}

?>