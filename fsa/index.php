<?php

    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Administration Control Panel';
    
    require_once( $fs_root . 'inc/common.php' );
    
    if ($session->userdata['userlevel'] < 5)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
    else
    {
        $body = file_get_contents( $fs['admin'] . 'index_body.htm' );
        
        $tpl =  $fs_root . 'template/admin.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
?>