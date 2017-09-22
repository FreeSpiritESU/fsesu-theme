<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; Unit Programme';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    
    $programme = new Programme;
    
    if ( isset( $_GET['id'] )) {
        // display the event details for the event id selected
        $body = $programme->displayProgramme( 'details' );
    } else {
        // display the programme
        $body = $programme->displayProgramme();
    }
    
    $right_content = downloads('programme', 'side_downloads', 1);
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;