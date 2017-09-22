<?php
    define('IN_FSW', true);
    $fs_root = './../';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    $css .= '@import url(' . $fs['css'] . 'planner.css);';
    
    $programme = new Programme;
    
    echo $programme->displayProgramme( 'details', 'planner' );