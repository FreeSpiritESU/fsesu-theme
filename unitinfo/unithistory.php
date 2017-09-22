<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; Unit History';
    
    require_once( $fs_root . 'inc/common.php' );
    
    $body = file_get_contents( 'unithistory_body.htm' );
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
            

            