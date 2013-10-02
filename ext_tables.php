<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addLLrefForTCAdescr('tx_devnullevents_event','EXT:dev_null_events/Resources/Private/csh/locallang_csh_tx_devnullevents_event.xml');

$TCA['tx_devnullevents_event'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event',		
		'label'     => 'label',
		// 'label_userFunc' => 'tx_devnullevents_event->label_userFunc',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY label DESC',
		'delete' => 'deleted',	
		'dividers2tabs' => '1',
		'canNotCollapse' => 1,
		'enablecolumns' => array(		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca_devnullevents_event.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_devnullevents_event.gif',
	),
);

$TCA['tx_devnullevents_cat'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_cat',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby'	=> 'sorting',	
		'delete'	=> 'deleted',	
		'canNotCollapse' => 1,
		'enablecolumns' => array(		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca_devnullevents_event_cat.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_devnullevents_cat.gif',
	),
);

$TCA['tx_devnullevents_schedule'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule',
		'label'     => 'title',
		'label_userFunc' => 'tx_devnullevents_schedule->label_userFunc',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY sh_startdate, title',
		'delete' => 'deleted',
		'hideTable' => 1,
		'dividers2tabs' => '1',
		'canNotCollapse' => 1,
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca_devnullevents_schedule.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_devnullevents_schedule.gif',
	),
);

$TCA['tx_devnullevents_text'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_text',		
		'label'     => 'title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'title',	
		'delete' => 'deleted',
		'dividers2tabs' => '1',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca_devnullevents_text.php',
		'iconfile'          => 'gfx/i/tt_content.gif',
	),
);

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key,pages,recursive';

// you add pi_flexform to be renderd when your plugin is shown
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';

t3lib_extMgm::addPlugin(array(
    'LLL:EXT:dev_null_events/locallang.xml:tt_content.list_type_pi1',
    $_EXTKEY . '_pi1',
    t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

// now, add your flexform xml-file
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/pi1/flexform_ds_pi1.xml');

if (TYPO3_MODE === 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_devnullevents_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'pi1/class.tx_devnullevents_pi1_wizicon.php';
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/static/dev_null_events/', 'dev/null Events');

?>