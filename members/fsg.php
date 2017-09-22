<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area &gt;&gt; Gallery';
   
    require_once( $fs_root . 'inc/common.php' );
         
    $iframe = $fs_root . 'members/fsg/';
      
    $tpl =  $fs_root . 'template/iframe.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
