<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area &gt;&gt; Merchandise';
    
    require_once( $fs_root . 'inc/common.php' );
    
    $right_content = downloads('merchandise', 'side_downloads', 1);
    
    $body = file_get_contents( $fs_root . 'members/merchandise_body.htm' );
   
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;