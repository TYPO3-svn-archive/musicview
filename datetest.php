<?php
	echo 'default: ' . date_default_timezone_get() . '<br />';

	$from = '1218369600';
	$to = '1218974400';
	echo 'from: ' . $from . ' => ' . date('G:i:s d-m-Y', $from) . ' => ' . mktime(0, 0, 0, 8, 10, 2008) . '<br />';
	$hour13 = 1218369600 - mktime(0, 0, 0, 8, 10, 2008);
	$r = mktime(0, 0, 0, 8, 10, 2008) + $hour13;
	
	echo 'r: ' . $r . ' (' . $hour13 . ')<br />';
	echo 'to: ' . $to . ' => ' . date('G:i:s d-m-Y', $to) . ' => ' . mktime(0, 0, 0, 8, 17, 2008) . '<br />';
	
	
?>