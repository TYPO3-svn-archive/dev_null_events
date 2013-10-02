<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$TCA['tx_devnullevents_schedule'] = array(
	'ctrl' => $TCA['tx_devnullevents_schedule']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,descr,fullday,sh_startdate,sh_starttime,sh_enddate,sh_endtime,colorbkg,colortxt'
	),
	'feInterface' => $TCA['tx_devnullevents_schedule']['feInterface'],
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
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'max' => '30',	
				'eval' => 'required',
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.descr_RTE",		
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
						'type' => 'script',
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
		'fullday' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.fullday',		
			'config' => array(
				'type' => 'check',
			)
		),
		'sh_startdate' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.sh_startdate',		
			'config' => array(
				'type'     => 'input',
				'size'     => '10',
				'max'      => '20',
				'eval'     => 'required,date',
				'default'  => '0'
			)
		),
		'sh_starttime' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.sh_starttime',		
			'displayCond' => 'FIELD:fullday:!=:1',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'time',
				'default' => '0',
			)
		),
		'sh_enddate' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.sh_enddate',		
			'config' => array(
				'type'     => 'input',
				'size'     => '10',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0'
			)
		),
		'sh_endtime' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents_schedule.sh_endtime',		
			'displayCond' => 'FIELD:fullday:!=:1',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'time',
				'default' => '0',
			)
		),
        'organizer' => array(        
            'exclude' => 0,        
            'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.organizer',        
            'config' => array(
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnulladdr_address',    
                'size' => 1,    
                'minitems' => 0,
                'maxitems' => 1,
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => ' AND linkjoin=\'schedule.org\'',
				'MM_insert_fields' => array('linkjoin' => 'schedule.org'),
				'wizards' => array(
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
                'size' => 1,    
                'minitems' => 0,
                'maxitems' => 1,
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => 'AND linkjoin=\'schedule.loc\'',
				'MM_insert_fields' => array('linkjoin' => 'schedule.loc'),
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
            )
        ),
        'instructor' => array(        
            'exclude' => 0,        
            'label' => 'LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:tx_devnullevents.instructor',        
            'config' => array(
                'type' => 'group',    
                'internal_type' => 'db',    
                'allowed' => 'tx_devnulladdr_address',
                'size' => 4,    
                'minitems' => 0,
                'maxitems' => 8,    
                'MM' => 'tx_devnullevents_event_partner_mm',
				'MM_table_where' => 'AND linkjoin=\'schedule.instr\'',
				'MM_insert_fields' => array('linkjoin' => 'schedule.instr'),
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
            )
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
			)
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
			)
		),
	),
    'types' => array(
        '0' => array('showitem' => '
			--div--;Termin,
				--palette--;;pTitle;;1-1-1,
				--palette--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:palette.schedule;pSched,
			--div--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:div.logistic,
				organizer,location,instructor,
			--div--;Style,
				--palette--;LLL:EXT:dev_null_events/Resources/Private/Language/locallang_devnull.xml:palette.colors;pColor'
			),
    ),
    'palettes' => array(
		'1' => array('showitem' => ''),
		'pTitle' => array('showitem' => 'title,--linebreak--,descr'),
        'pSched' => array('showitem' => 'sh_startdate, sh_starttime, fullday, --linebreak--, sh_enddate, sh_endtime', 'canNotCollapse' => 1),
        'pColor' => array('showitem' => 'colorbkg, colortxt', 'canNotCollapse' => 1)
    )
);
?>