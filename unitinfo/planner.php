<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; Year Planner';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/calendar.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    $css .= '@import url(' . $fs['css'] . 'planner.css);';
    
    $programme = new Programme; 
    
    if ( isset( $_GET['id'] )) {
        // display the event details for the event id selected
        $body = planner( $programme->displayProgramme( 'details', 'planner' ));
    } else {
        // display the programme
        $body = planner();
    }
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
