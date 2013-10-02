<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$TCA['tx_devnullevents_text'] = array(
	'ctrl' => $TCA['tx_devnullevents_text']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,descr'
	),
	'feInterface' => $TCA['tx_devnullevents_text']['feInterface'],
	'columns' => array(
		'hidden' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_text.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'max' => '30',	
				'eval' => 'required',
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_text.descr_RTE",		
			"config" => Array (
				"type" => "text",
				"cols" => "40",
				"rows" => "10",
			),
		),
	),
    'types' => array(
        '0' => array('showitem' => '
			--div--;Text,
				title,
				descr;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css]',
			),
    ),
    'palettes' => array(
		'1' => array('showitem' => 'title'),
    )
);
?>