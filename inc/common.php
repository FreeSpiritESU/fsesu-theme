<?php

   if( !defined('IN_FSW') )
   {
     die();
   }

   require_once( $fs_root . 'inc/config.inc.php' );
   include_once( $fs_root . 'inc/functions.php' );
   include_once( $fs_root . 'inc/classes/Nav.php' );
   include_once( $fs_root . 'inc/classes/Session.php' );
   include_once( $fs_root . 'inc/classes/User.php' );
   
   connectDB();
   
   $nav = new nav;
   $session = new session;
   $user = new User;
   
   include_once( $fs_root . 'inc/login.php' );
   
   $page_title = 'FreeSpirit ESU ';
   
?>