<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Parents Info';
    
    require_once( $fs_root . 'inc/common.php' );
   
    $body = '<h3>Information for Parents</h3>';
   
    $parent_links = new Nav;
    $parent_links->sql_where = "WHERE parent = 27";
    $result = $parent_links->getNav();
   
    $body .= "
            <ul>";
    while( $row = mysql_fetch_array( $result ) ) {
        $body .= "
                <li><a href='{$row['link']}'>{$row['name']}</a></li>";
    }
    $body .= "
            </ul>";

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
