<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$TCA['tx_devnullevents_cat'] = array(
	'ctrl' => $TCA['tx_devnullevents_cat']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,description'
	),
	'feInterface' => $TCA['tx_devnullevents_cat']['feInterface'],
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
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull:tx_devnullevents_cat.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'max' => '30',	
				'eval' => 'required',
			)
		),
		'description' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull:tx_devnullevents_cat.description',		
			'config' => array(
				'type' => 'text',
				'cols' => '30',	
				'rows' => '8',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, description;;;;3-3-3')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

?>