<?php
	$filename = 'FreeSpirit_Events.csv'; 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header('Content-Description: File Transfer');
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename={$filename}");
	header("Expires: 0");
	header("Pragma: public");

    define('IN_FSW', true);
    $fs_root = './../';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    
    $programme = new Programme;
    $programme->outputCSV(); 