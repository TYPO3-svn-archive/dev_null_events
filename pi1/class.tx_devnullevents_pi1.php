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
class tx_devnullevents_pi1 extends tslib_pibase {
	public $prefixId      = 'tx_devnullevents';		// Same as class name
	public $scriptRelPath = 'pi1/class.tx_devnullevents_pi1.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'dev_null_events';	// The extension key.
	public $pi_checkCHash = TRUE;
	
	public $lConf         = array();
	
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
		
		// return t3lib_utility_Debug::viewArray($conf);

		// init Flexform values
		$this->init();
		
		$this->conf['displayType']		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'displayType', 'sDEF');

		switch($this->conf['displayType']) {
			case 1:
				$_procObj = & t3lib_div::getUserObj('user_devnullevents_pi1_list');
				$content .=  $_procObj->render($this);
				break;
			case 2:
				$_procObj = & t3lib_div::getUserObj('user_devnullevents_pi1_view');
				$content .=  $_procObj->render($this);
				break;
			default:
				$_procObj = & t3lib_div::getUserObj('user_devnullevents_pi1_calendar');
				$content .=  $_procObj->render($this);
		}
		
		return $this->pi_wrapInBaseClass($content);

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


if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/dev_null_events/pi1/class.tx_devnullevents_pi1.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/dev_null_events/pi1/class.tx_devnullevents_pi1.php']);
}

?>