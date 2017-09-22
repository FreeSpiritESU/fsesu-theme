<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; Press Cuttings';
    
    require_once( $fs_root . 'inc/common.php' );
   
    $body = pressCuttings();

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
