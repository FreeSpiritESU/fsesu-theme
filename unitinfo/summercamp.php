<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; Summer Camp';
    
    require_once( $fs_root . 'inc/common.php' );

    $right_content = downloads('summer', 'side_downloads', 1);
    
    $body = file_get_contents( 'summercamp_body.htm' );
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;