<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Camp Diaries &gt;&gt; Scotland 2008';
   
    require_once( $fs_root . 'inc/common.php' );
         
    $iframe = $fs_root . 'campdiaries/scotland08/';
      
    $tpl =  $fs_root . 'template/iframe.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;