<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Unit Info &gt;&gt; What is Explorer Scouting?';

    require_once( $fs_root . 'inc/common.php' );

    //$right_content = downloads('coc', 'side_downloads', 1);

    $body = file_get_contents( 'whatisexplorerscouting_body.htm' );

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;