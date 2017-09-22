<?php
    define('IN_FSW', true);
    $fs_root = './';
    $page = 'Links';
    
    require_once( $fs_root . 'inc/common.php' );
    
    $body = "<div class='center'><h2>Links</h2></div>"
          . links('Explorer Web Sites', 'Explorer')
          . links('District/County Web Sites', 'District')
          . links('National Web Sites', 'National')
          . links('Event Websites', 'Event');
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
