<?php
    define('IN_FSW', true);
    $fs_root = './../';
    require_once( $fs_root . 'inc/common.php' );
    
    $page_title .= '>> Administration Control Panel >> News';
    
    if ($session->userdata['userlevel'] < 5)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
      
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
    else
    {
        require_once( $fs_root . 'inc/classes/News.php' );
        
        /*
        * TinyMCE - a platform independent web based Javascript 
        * HTML WYSIWYG editor control released as Open Source 
        * under LGPL by Moxiecode Systems AB. It has the ability 
        * to convert HTML TEXTAREA fields or other HTML elements
        * to editor instances. TinyMCE is very easy to integrate 
        * into other Content Management Systems.
        *
        * add to the page head
        */
        $extra_head_info = "
        <!-- TinyMCE -->
         <script type='text/javascript' src='{$fs['js']}tiny_mce/tiny_mce.js'> 
         </script>
         <script type='text/javascript' src='{$fs['js']}tiny_mce/article_init.js'>
         </script>
        <!-- /TinyMCE -->
        <script type='text/javascript' src='{$fs['js']}formHide.js'> 
        </script>";
        
        $news = new News;
        
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'mainnews';
        
        if (!isset ($_GET['edit']))
        {
            $form = $news->addNewsForm( $type );
        }
        
        if (isset ($_GET['edit']) && isset ($_GET['id']))
        {
         
            $id = $_GET['id'];
            
            $news->sql_where = "WHERE id = '{$id}'";
            $result = $news->getNews();
            
            $row = mysql_fetch_assoc( $result );
            extract($row);
            
            $form = $news->editNewsForm( $id, $title, $summary, $article, $type );
        }
        $body .= $news->listNews( $type ) . $form;
        
        $tpl =  $fs_root . 'template/admin.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
?>