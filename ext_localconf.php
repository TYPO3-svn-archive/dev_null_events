<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Activate Hooks in TCE-Main (processDatamapClass)
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:dev_null_events/inc/class.tx_devnullevents_tcemainprocdm.php:tx_devnullevents_tcemainprocdm';

t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_devnullevents_event=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_devnullevents_pi1.php', '_pi1', 'list_type', 1);

?>