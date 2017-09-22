<?php
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: inline; filename="FSESUProgrammeCalendar.ics"');
	
	define('IN_FSW', true);
    $fs_root = './../';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    
    $programme = new Programme;
	$ics = $programme->outputICSFile();
	
	echo $ics;