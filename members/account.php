<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area >> My Account';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/UserAccount.php' );
    $account = new UserAccount( $session->userdata['uid'] );
    
    // check the user has a logged in
    if (!$session->logged_in)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
        
        die();
    }
    
    // check if the user wants to edit their details
    if ( isset($_GET['edit']) ) {
        $body = '<h3>Edit My Account</h3><br />' . $account->editAccount();
    } else {
        $body = '<h3>My Account</h3><br />' . $account->displayAccount();
        //$body .= "<br /><a href='?edit'>Edit details</a>";
    }
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>