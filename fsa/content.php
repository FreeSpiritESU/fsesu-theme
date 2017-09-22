<?php

    define('IN_FSW', true);
    $fs_root = './../';
    $page = 'Administration Control Panel >> Pages/Content';
    
    require_once( $fs_root . 'inc/common.php' );
    
    
    // check the user has a high enough userlevel to view this page
    if ($session->userdata['userlevel'] < 5)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
    else
    {  
        // check whether the user has already asked to edit a page
        if (isset ($_GET['edit']) && isset ($_GET['page']))
        {
            // set the page variable for the page to be edited
            $page = $_GET['page'];
            
           /**
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
            <script type='text/javascript' src='{$fs['js']}tiny_mce/content_init.js'>
            </script>
        <!-- /TinyMCE -->";
         
            $file = $fs_root . $page . '_body.htm';
            $content = (file_exists( $file )) ? file_get_contents( $file ): '';
            $content = str_replace( '%FS_ROOT%', $fs_root, $content );
            
            $mce = "
            <div id='mce'>
                <a name='editor' />
                <form method='post' action='{$fs['admin']}process.php?updateContent&amp;page=$page'>
                
                    <textarea id='editor1' name='editor1' cols='120' rows='60' class='mceAdvanced'>$content</textarea><br />
                </form>
                
                <a href='http://tinymce.moxiecode.com?id=powered_by_tinymce'>
                <img src='http://tinymce.sourceforge.net/buttons/powered_by_tinymce.png' border='0' width='88' height='32' alt='Powered by TinyMCE' /></a>
            </div>
";
        }
      
        $body .= $nav->listHTMLPages();
      
        $tpl =  $fs_root . 'template/admin.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
?>