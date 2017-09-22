<?php
    define('IN_FSW', true);
    $fs_root = './';
    $page = 'Home';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/News.php' );
    
    $body = "
            <div class='section'>";
    $body .= file_get_contents('http://www.freespiritesu.org.uk/members/fsg/main.php?g2_view=imageblock.External&g2_blocks=randomImage&g2_show=title&g2_exactSize=400');
    $body .= "
            </div>";
    
    $body .= $separator . "
            <div class='section'>";
    $whatsnew = new news;
    $body .= $whatsnew->displayNews(3);
    $body .= "
            </div>" . $separator;
            
    $body .= "
            <h2>News</h2>";
    
    $news = new News;
    $news->sql_limit = 'LIMIT 5';
    $body .= $news->displayNewsArticle();
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
