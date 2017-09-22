<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area >> Awards';
    
    require_once( $fs_root . 'inc/common.php' );
   
    $body = file_get_contents( 'awards_body.htm' );

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
