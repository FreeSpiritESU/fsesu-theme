<?php
    define('IN_FSW', true);
    $fs_root = './';
    $page = 'Login';
    
    require_once( $fs_root . 'inc/common.php' );
    
    if (isset($_POST['login']))
    {
        // try to login the user
        $user->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
        
    }
   
    if (isset($_GET['logout']))
    {
        // logout the user and reset them as a guest
        $user->logout();
    }
    
    $tpl =  $fs_root . 'template/login.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>