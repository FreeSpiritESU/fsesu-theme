<?php
    define('IN_FSW', true);
    $fs_root = '../';
    $page = 'Sitemap';
    
    require_once( $fs_root . 'inc/common.php' );   
    
    $sitemap = new nav;
    $sitemap->displayNav('class');
    $body = '
         <h3>Sitemap</h3>';
    $body .= $sitemap->nav;
    $body .= "
         <ul class='menu'>
            <li><a href='{$fs_root}sitemap/' title='Sitemap'>Sitemap</a></li>
            <li><a href='{$fs_root}contact.php' title='Contact Us'>Contact Us</a></li>
         </ul>";
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>