<?php
    define('IN_FSW', true);
    $fs_root = './../../';
    $page = 'Unit Info &gt;&gt; Downloads';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/File.php' );

    $files = new File;

    $body = "
            <div class='center'><h2>Downloads</h2></div>";
    $body .= $files->displayDownloads('featured', 'main_downloads', 'Featured Downloads', true);
    $body .= $files->displayDownloads('summer', 'main_downloads', 'Summer Camp Information & Forms', true);
    $body .= $files->displayDownloads('programme', 'main_downloads', 'Programme', true);
    $body .= $files->displayDownloads('newsletter', 'main_downloads', 'FreeSpirit News', true);
    $body .= $files->displayDownloads('newstart', 'main_downloads', 'New Starter Information', true);
    $body .= $files->displayDownloads('coc', 'main_downloads', 'Code Of Conduct', true);
    $body .= $files->displayDownloads('camp', 'main_downloads', 'Camping Forms', true);
    $body .= $files->displayDownloads('kit', 'main_downloads', 'Kit Lists', true); 
    $body .= $files->displayDownloads('directions', 'main_downloads', 'Directions to various places', true); 
    $body .= $files->displayDownloads('other', 'main_downloads', 'Other Stuff');
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
