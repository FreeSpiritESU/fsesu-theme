<?php

    define('IN_FSW', true);
    $fs_root = './../';
    require_once( $fs_root . 'inc/common.php' );
    
    $page = 'Administration Control Panel >> Navigation';
    
    if ($session->userdata['userlevel'] < 5)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
    else
    {
        $extra_head_info = "
        <script type='text/javascript' src='{$fs['js']}formHide.js'> 
        </script>";
        
        if (!isset( $_GET['addLink'] ) || !isset( $_GET['edit'] ) 
        || !isset( $_GET['delete'] ) || !isset( $_GET['editLink'] ))
        {
            $form = $nav->addLinkForm();
        }
        
        if (isset ($_GET['edit']) && isset ($_GET['id']) && isset ($_GET['parent']))
        {
            $id = $_GET['id'];
            $parent = $_GET['parent'];
            
            $nav->sql_where = "WHERE id = '{$id}'";
            $result = $nav->getNav();
            
            $row = mysql_fetch_assoc( $result );
            extract($row);
            
            $form = $nav->editLinkForm( $id, $name, $link, $ordering, $level, $parent, $intext );
        }
        
        $body .= $nav->listNavigation() . $form;
        
        $tpl =  $fs_root . 'template/admin.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
?>