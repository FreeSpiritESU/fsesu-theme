<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area &gt;&gt; Forum';
   
    require_once( $fs_root . 'inc/common.php' );
    
    // check the user has a logged in
    if (!$session->logged_in)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
        die();
    }
     
    $iframe = $fs_root . 'members/fsf/';
      
    $tpl =  $fs_root . 'template/iframe.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
