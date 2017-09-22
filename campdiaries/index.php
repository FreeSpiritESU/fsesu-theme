<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Camp Diaries';
   
    require_once( $fs_root . 'inc/common.php' );
   
    $body = file_get_contents( 'index_body.htm' ) . $body;
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>