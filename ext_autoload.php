<?php
$extensionPath = t3lib_extMgm::extPath('dev_null_events');

$default = array(
		't3lib_utility_debug'				=> PATH_t3lib.'utility/class.t3lib_utility_debug.php',
		't3lib_befunc'						=> PATH_t3lib.'class.t3lib_befunc.php',
		
		'tx_devnullevents_event'			=> $extensionPath.'api/class.tx_devnullevents_event.php',
		'tx_devnullevents_schedule'			=> $extensionPath.'api/class.tx_devnullevents_schedule.php',

		'user_devnullevents_pi1_calendar'	=> $extensionPath.'pi1/user.tx_devnullevents_pi1.calendar.php',
		'user_devnullevents_pi1_list'		=> $extensionPath.'pi1/user.tx_devnullevents_pi1.list.php',
		'user_devnullevents_pi1_view'		=> $extensionPath.'pi1/user.tx_devnullevents_pi1.view.php',
);
return $default;
?>
