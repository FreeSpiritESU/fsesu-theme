<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Camp Diaries &gt;&gt; Serbia 2006';
   
    require_once( $fs_root . 'inc/common.php' );
         
    $iframe = $fs_root . 'campdiaries/serbia06/';
      
    $tpl =  $fs_root . 'template/iframe.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;