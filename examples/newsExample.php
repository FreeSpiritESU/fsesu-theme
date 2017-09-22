<?php

    include 'class.news.php';
    $news = new news;
    $news->sql_where = 'WHERE date = TODAY()';  //optional
    $news->displayNews;
    
?>