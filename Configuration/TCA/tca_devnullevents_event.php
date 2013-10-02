<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_devnullevents_event'] = array(
	'ctrl' => $TCA['tx_devnullevents_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'label,title,teaser'
	),
	'feInterface' => $TCA['tx_devnullevents_event']['feInterface'],
	'columns' => array(
		'hidden' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			),
		),
		'label' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.label',
			'config' => Array (
				'type' => 'none',
				'size' => 50,
			)
		),
		'title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'max' => '30',	
				'eval' => 'required',
			),
		),
		'teaser' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.teaser',		
			'config' => array(
				'type' => 'text',
				'cols' => '30',	
				'rows' => '8',
			),
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.descr_RTE",		
			"config" => Array (
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnullevents_text',    
                'size' => 2,    
                'minitems' => 0,
                'maxitems' => 1,
				'wizards' => array(
					'_PADDING' => '4',
//					'_DISTANCE' => '4',
					'suggest' => array(
						'type' => 'suggest',
					),
					'add' => array(
						'type' => 'popup',
						'title' => 'Addnew',
						'icon' => 'add.gif',
						'params' => array(
							'table'=>'tx_devnullevents_text',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
						'JSopenParams' => 'height=750,width=750,status=0,menubar=0,scrollbars=1',
					),
					'edit' => array(
						'_PADDING' => '4',
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'edit2.gif',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=750,width=750,status=0,menubar=0,scrollbars=1',
					),
				),
			),
		),
        'organizer' => array(        
            'exclude' => 0,        
            'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.organizer',        
            'config' => array(
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnulladdr_address',    
				'foreign_table_where' => ' AND tx_devnulladdr_address.type=1',
                'size' => 1,    
                'minitems' => 0,
                'maxitems' => 1,
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => ' AND linkjoin=\'events.org\'',
				'MM_insert_fields' => array('linkjoin' => 'events.org'),
				'wizards' => array(
					'_PADDING' => '4',
//					'_DISTANCE' => '4',
					'suggest' => array(
						'type' => 'suggest',
					),
				),
            ),
        ),
        'location' => array(        
            'exclude' => 0,        
            'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.location',        
            'config' => array(
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnulladdr_address',    
				'foreign_table_where' => ' AND tx_devnulladdr_address.type=1',
                'size' => 1,    
                'minitems' => 0,
                'maxitems' => 1,
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => 'AND linkjoin=\'events.loc\'',
				'MM_insert_fields' => array('linkjoin' => 'events.loc'),
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
            ),
        ),
        'instructor' => array(        
            'exclude' => 0,        
            'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.instructor',        
            'config' => array(
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnulladdr_address',    
				'foreign_table_where' => ' AND tx_devnulladdr_address.type=0',
                'size' => 4,    
                'minitems' => 0,
                'maxitems' => 8,    
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => 'AND linkjoin=\'events.instr\'',
				'MM_insert_fields' => array('linkjoin' => 'events.instr'),
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
            ),
        ),
		'cat' => array(		
			'exclude' => 0,
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.cat',		
			'config' => array(
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_devnullevents_cat',	
				'size' => 8,	
				'minitems' => 1,
				'maxitems' => 16,	
				"MM" => "tx_devnullevents_event_cat_mm",
				'MM_insert_fields' => array('ident' => 'devnullevents_event'),
				'wizards' => array(
					'_PADDING' => '4',
//					'_DISTANCE' => '4',
					'suggest' => array(
						'type' => 'suggest',
					),
					'add' => array(
						'type' => 'script',
						'title' => 'Addnew',
						'icon' => 'add.gif',
						'params' => array(
							'table'=>'tx_devnullevents_cat',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'set'
						),
						'script' => 'wizard_add.php',
						'JSopenParams' => 'height=750,width=750,status=0,menubar=0,scrollbars=1',
					),
					'edit' => array(
						'_PADDING' => '4',
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'edit2.gif',
						'script' => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=750,width=750,status=0,menubar=0,scrollbars=1',
					),
				),
			),
		),
		'schedules' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_event.schedules',		
			'config' => array(
				'type' => 'inline',
                "foreign_table" => "tx_devnullevents_schedule",
                "foreign_field" => "parentid",
                "maxitems" => 10,
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
 			),
		),
		'colorbkg' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.colorbkg',		
			'config' => array(
				'type' => 'input',	
				'size' => '16',	
				'max' => '16',	
				'wizards' => array(
					'_PADDING' => 2,
					'color' => array(
						'title' => 'Color:',
						'type' => 'colorbox',
						'dim' => '12x12',
						'tableStyle' => 'border:solid 1px black;',
						'script' => 'wizard_colorpicker.php',
						'JSopenParams' => 'height=300,width=250,status=0,menubar=0,scrollbars=1',
					),
				),
			),
		),
		'colortxt' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.colortxt',		
			'config' => array(
				'type' => 'input',	
				'size' => '16',	
				'max' => '16',
				'wizards' => array(
					'_PADDING' => 2,
					'color' => array(
						'title' => 'Color:',
						'type' => 'colorbox',
						'dim' => '12x12',
						'tableStyle' => 'border:solid 1px black;',
						'script' => 'wizard_colorpicker.php',
						'JSopenParams' => 'height=300,width=250,status=0,menubar=0,scrollbars=1',
					),
				),
			),
		),
	),
	'types' => array(
		'0' => array('showitem' => '
			--div--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:div.event,
				--palette--;;pTitle;1-1-1,
					teaser, descr, cat,
			--div--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:div.logistic,
				organizer,location,instructor,
			--div--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:div.schedule,
				schedules,
			--div--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:div.style,
				--palette--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:palette.colors;pColors',
		),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'pTitle' => array('showitem' => 'title'),
        'pColors' => array('showitem' => 'colorbkg, colortxt', 'canNotCollapse' => 1),
	),
);


?>