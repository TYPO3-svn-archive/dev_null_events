<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dev_null_events".
 *
 * Auto generated 01-10-2013 22:07
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'dev/null Events',
	'description' => 'Calendar and event plugin based on fullcalendar.js with support for qTips2',
	'category' => 'plugin',
	'author' => 'W. Rotschek',
	'author_email' => 'typo3@dev-null.at',
	'shy' => '',
	'dependencies' => 'dev_null_addr',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'dev_null_addr' => '0.0.0-',
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:81:{s:9:"ChangeLog";s:4:"1111";s:16:"ext_autoload.php";s:4:"8c02";s:12:"ext_icon.gif";s:4:"15ae";s:17:"ext_localconf.php";s:4:"7b9b";s:14:"ext_tables.php";s:4:"7510";s:14:"ext_tables.sql";s:4:"41af";s:13:"locallang.xml";s:4:"be58";s:10:"README.txt";s:4:"9fa9";s:12:"t3jquery.txt";s:4:"78fc";s:45:"Configuration/TCA/tca_devnullevents_event.php";s:4:"7ec7";s:49:"Configuration/TCA/tca_devnullevents_event_cat.php";s:4:"6303";s:48:"Configuration/TCA/tca_devnullevents_schedule.php";s:4:"3659";s:44:"Configuration/TCA/tca_devnullevents_text.php";s:4:"f595";s:50:"Configuration/static/dev_null_events/constants.txt";s:4:"a38e";s:46:"Configuration/static/dev_null_events/setup.txt";s:4:"4cd3";s:48:"Resources/Private/Language/locallang_devnull.xml";s:4:"b4b1";s:42:"Resources/Private/Templates/eventlist.html";s:4:"f41f";s:42:"Resources/Private/Templates/eventview.html";s:4:"55bd";s:45:"Resources/Private/Templates/fullcalendar.html";s:4:"ad35";s:62:"Resources/Private/csh/locallang_csh_tx_devnullevents_event.xml";s:4:"cc95";s:52:"Resources/Public/Icons/icon_tx_devnullevents_cat.gif";s:4:"d6c6";s:52:"Resources/Public/Icons/icon_tx_devnullevents_cat.png";s:4:"2495";s:54:"Resources/Public/Icons/icon_tx_devnullevents_event.gif";s:4:"271c";s:54:"Resources/Public/Icons/icon_tx_devnullevents_event.png";s:4:"66f1";s:57:"Resources/Public/Icons/icon_tx_devnullevents_schedule.gif";s:4:"7019";s:57:"Resources/Public/Icons/icon_tx_devnullevents_schedule.png";s:4:"ad2d";s:53:"Resources/Public/Icons/icon_tx_devnullevents_text.png";s:4:"3aa5";s:54:"Resources/Public/Scripts/fullcalendar/fullcalendar.css";s:4:"e366";s:53:"Resources/Public/Scripts/fullcalendar/fullcalendar.js";s:4:"1db6";s:57:"Resources/Public/Scripts/fullcalendar/fullcalendar.min.js";s:4:"0c37";s:60:"Resources/Public/Scripts/fullcalendar/fullcalendar.print.css";s:4:"e047";s:45:"Resources/Public/Scripts/fullcalendar/gcal.js";s:4:"5db5";s:57:"Resources/Public/Scripts/fullcalendar-1.6.1/changelog.txt";s:4:"bf94";s:60:"Resources/Public/Scripts/fullcalendar-1.6.1/fullcalendar.css";s:4:"e020";s:59:"Resources/Public/Scripts/fullcalendar-1.6.1/fullcalendar.js";s:4:"aa52";s:63:"Resources/Public/Scripts/fullcalendar-1.6.1/fullcalendar.min.js";s:4:"03ec";s:66:"Resources/Public/Scripts/fullcalendar-1.6.1/fullcalendar.print.css";s:4:"c75e";s:51:"Resources/Public/Scripts/fullcalendar-1.6.1/gcal.js";s:4:"2643";s:55:"Resources/Public/Scripts/fullcalendar-1.6.1/license.txt";s:4:"f08f";s:57:"Resources/Public/Scripts/fullcalendar-1.6.4/changelog.txt";s:4:"9c3c";s:60:"Resources/Public/Scripts/fullcalendar-1.6.4/fullcalendar.css";s:4:"cb86";s:59:"Resources/Public/Scripts/fullcalendar-1.6.4/fullcalendar.js";s:4:"c353";s:63:"Resources/Public/Scripts/fullcalendar-1.6.4/fullcalendar.min.js";s:4:"1520";s:66:"Resources/Public/Scripts/fullcalendar-1.6.4/fullcalendar.print.css";s:4:"1a2e";s:51:"Resources/Public/Scripts/fullcalendar-1.6.4/gcal.js";s:4:"2309";s:55:"Resources/Public/Scripts/fullcalendar-1.6.4/license.txt";s:4:"f08f";s:51:"Resources/Public/Scripts/jquery/jquery-1.8.1.min.js";s:4:"a9a0";s:51:"Resources/Public/Scripts/jquery/jquery-1.9.1.min.js";s:4:"3977";s:62:"Resources/Public/Scripts/jquery/jquery-ui-1.10.2.custom.min.js";s:4:"21ec";s:62:"Resources/Public/Scripts/jquery/jquery-ui-1.8.23.custom.min.js";s:4:"ddaf";s:37:"Resources/Public/Scripts/qtip/INSTALL";s:4:"cf27";s:49:"Resources/Public/Scripts/qtip/jquery-1.3.2.min.js";s:4:"181f";s:54:"Resources/Public/Scripts/qtip/jquery.qtip-1.0.0-rc3.js";s:4:"1cac";s:58:"Resources/Public/Scripts/qtip/jquery.qtip-1.0.0-rc3.min.js";s:4:"9eb4";s:37:"Resources/Public/Scripts/qtip/LICENSE";s:4:"7657";s:42:"Resources/Public/Scripts/qtip/REQUIREMENTS";s:4:"5d5f";s:51:"Resources/Public/Scripts/qtip-2.0.1/jquery.qtip.css";s:4:"196e";s:50:"Resources/Public/Scripts/qtip-2.0.1/jquery.qtip.js";s:4:"718e";s:55:"Resources/Public/Scripts/qtip-2.0.1/jquery.qtip.min.css";s:4:"24f9";s:54:"Resources/Public/Scripts/qtip-2.0.1/jquery.qtip.min.js";s:4:"7416";s:55:"Resources/Public/Scripts/qtip-2.1.1/imagesloaded.min.js";s:4:"c43b";s:51:"Resources/Public/Scripts/qtip-2.1.1/jquery.qtip.css";s:4:"6c67";s:50:"Resources/Public/Scripts/qtip-2.1.1/jquery.qtip.js";s:4:"a9ba";s:55:"Resources/Public/Scripts/qtip-2.1.1/jquery.qtip.min.css";s:4:"1374";s:54:"Resources/Public/Scripts/qtip-2.1.1/jquery.qtip.min.js";s:4:"d141";s:40:"Resources/Public/css/dev-null-events.css";s:4:"339e";s:43:"Resources/Public/css/fullcalendar-yaml4.css";s:4:"8f85";s:36:"Resources/Public/css/qtip.custom.css";s:4:"033b";s:36:"api/class.tx_devnullevents_event.php";s:4:"e6ce";s:39:"api/class.tx_devnullevents_schedule.php";s:4:"4e46";s:14:"doc/manual.sxw";s:4:"98f9";s:44:"inc/class.tx_devnullevents_tcemainprocdm.php";s:4:"27e1";s:36:"json/class.tx_devnullevents_json.php";s:4:"7d6c";s:14:"pi1/ce_wiz.png";s:4:"1b7a";s:34:"pi1/class.tx_devnullevents_pi1.php";s:4:"799e";s:42:"pi1/class.tx_devnullevents_pi1_wizicon.php";s:4:"496f";s:23:"pi1/flexform_ds_pi1.xml";s:4:"4375";s:17:"pi1/locallang.xml";s:4:"64f6";s:42:"pi1/user.tx_devnullevents_pi1.calendar.php";s:4:"8144";s:38:"pi1/user.tx_devnullevents_pi1.list.php";s:4:"43e8";s:38:"pi1/user.tx_devnullevents_pi1.view.php";s:4:"6b79";}',
	'suggests' => array(
	),
);

?>