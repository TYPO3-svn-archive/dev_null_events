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
 class user_devnullevents_pi1_calendar {

	private $piObj;
	private $cObj;
	private $conf;
	

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
		
		$this->conf['singleview']		= $piObj->pi_getFFvalue($this->cObj->data['pi_flexform'], 'singleview', 'sFullCal');

		// load additional css
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['fullcalendar.']['cssScreen'], 'stylesheet', 'all');
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['fullcalendar.']['cssPrint'],  'stylesheet', 'print');
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['fullcalendar.']['cssCustom'], 'stylesheet', 'all');
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile($this->conf['resources.']['qtip.']['cssScreen'], 'stylesheet', 'all');

		// load additional js
		$GLOBALS['TSFE']->getPageRenderer()->addJsFile($this->conf['resources.']['fullcalendar.']['jquery']);
		$GLOBALS['TSFE']->getPageRenderer()->addJsFile($this->conf['resources.']['qtip.']['jquery']);

		$templateCode = $piObj->cObj->fileResource($this->conf['calendar.']['template']);
		
		$subParts['content'] = $piObj->cObj->getSubpart($templateCode, '###BODYTEXT###');
		$subParts['script'] = $piObj->cObj->getSubpart($templateCode, '###HEADERSCRIPT###');
		$subParts['style'] = $piObj->cObj->getSubpart($templateCode, '###HEADERSTYLE###');
		
		$conf = array(
			'parameter' => $GLOBALS['TSFE']->id,
			'returnLast' => 'url',
			'additionalParams' => '&type=' . $this->conf['jsonTypeNum'] . '&tx_devnullevents[cal]=' . $this->cObj->data['uid'],
			'useCacheHash' => 0,
		);
		$link = $piObj->cObj->typoLink('', $conf);
		// $link = t3lib_div::locationHeaderUrl($link);

		$marker = array('###JSON_FEED_URL###' => $link);
		
		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode(
			'devnullevents.fullcalendar',
			$piObj->cObj->substituteMarkerArray($subParts['script'], $marker),
			FALSE, FALSE);

		$GLOBALS['TSFE']->getPageRenderer()->addCssInlineBlock('Fullcalendar', $subParts['style']);

		// $content = t3lib_utility_Debug::viewArray($subParts);
		// $content .= t3lib_utility_Debug::viewArray($piObj->piVars);
		
		$content .= $subParts['content'];
	
		return $content;
	}
}

?>