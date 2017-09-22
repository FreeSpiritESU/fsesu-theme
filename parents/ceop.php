<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Parents Info &gt;&gt; Child Exploitation and Online Protection Centre';
    
    require_once( $fs_root . 'inc/common.php' );
   
    $body = file_get_contents( 'ceop_body.htm' );
   
    //$right_content = downloads('ceop', 'side_downloads', 1);
 
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
