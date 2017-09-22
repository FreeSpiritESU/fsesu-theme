<?php
    define('IN_FSW', true);
    $fs_root = './../../';
    $page = 'Unit Info &gt;&gt; Unit Programme &gt;&gt; Details';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    $css .= '@import url(' . $fs['css'] . 'planner.css);';
    
    $programme = new Programme;
    
    $body = $programme->displayProgramme( 'details', 'planner' );
	
	$tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;