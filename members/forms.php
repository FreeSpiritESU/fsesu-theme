<?php
    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Members Area &gt;&gt; File Downloads';
   
    require_once( $fs_root . 'inc/common.php' );
    
    // check the user has a logged in
    if ($session->userdata['userlevel'] < 5){
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
        die();
    }

    $extra_head_info = "
        <link type='text/css' rel='stylesheet' href='/js/php_file_tree/styles/default/default.css' />
        <script src='/js/php_file_tree/php_file_tree.js' type='text/javascript'></script>";
    
    //require_once( $fs_root . 'inc/classes/File.php' );
    include( $fs_root . 'js/php_file_tree/php_file_tree.php' );

    //$files = new File;

    $body = "<h3>Files</h3>\n\t\t\t<div id='fileTree'></div>\n";
    $path = $_SERVER['DOCUMENT_ROOT'] . '/files';
    $body .= php_file_tree($path, "/download.php?dl=[link]");
    //$body .= $files->showLocalFiles("files");
  
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;

/*<link type='text/css' rel='stylesheet' href='/css/filetable.css' />
<script type='text/javascript' src='/js/jquery.min.js'></script>
<script type='text/javascript' src='/js/jqueryFileTree/jqueryFileTree.js'></script>
<script type='text/javascript' src='/js/jqueryFileTree.js'></script>*/
        