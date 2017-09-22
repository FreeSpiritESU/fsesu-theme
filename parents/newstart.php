<?php
    define('IN_FSW', true);
    $fs_root = '../';
    $page = 'Parents Info &gt;&gt; New Starter Info';
    
    require_once( $fs_root . 'inc/common.php' );
    
    $right_content = downloads('newstart', 'side_downloads', 1);
    
    $body = file_get_contents( 'newstart_body.htm' );
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;

            

            