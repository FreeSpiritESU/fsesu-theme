<?php
    define('IN_FSW', true);
    $fs_root = '../';
    $page = 'Parents Info &gt;&gt; Directions';
    
    require_once( $fs_root . 'inc/common.php' );
    
    $body = "<div class='center'><h2>Directions</h2></div>"
        . downloads('directions', 'main_downloads');
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>