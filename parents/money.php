<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Parents Info &gt;&gt; Money Matters';
    
    require_once( $fs_root . 'inc/common.php' );
   
    $body = file_get_contents( 'money_body.htm' );
   
    $right_content = downloads('money', 'side_downloads', 1);
 
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
