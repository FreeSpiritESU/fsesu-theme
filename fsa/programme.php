<?php

    define('IN_FSW', true);
    $fs_root = './../';
    require_once( $fs_root . 'inc/common.php' );
    
    $page = 'Administration Control Panel >> Programme';
    
    if ($session->userdata['userlevel'] < 5)
    {
        $body = file_get_contents( $fs_root . 'error403_body.htm' );
        
        $tpl =  $fs_root . 'template/default.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
    else
    {
        require_once( $fs_root . 'inc/classes/Programme.php' );
      
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
        $extra_head_info = '
      <!-- TinyMCE -->
         <script type="text/javascript" src="' . $fs['js']. 'tiny_mce/tiny_mce.js"> 
         </script>
         <script type="text/javascript" src="' . $fs['js'] . 'tiny_mce/programme_init.js">
         </script>
      <!-- /TinyMCE -->
      <script type="text/javascript" src="' . $fs['js'] . 'formHide.js"> 
      </script>
      
      <!-- Popup Calendar Scripts -->
          <script type="text/javascript" src="' . $fs['js'] . 'calendar.js"></script>
          <script type="text/javascript" src="' . $fs['js'] . 'calendar-en.js"></script>
          <script type="text/javascript" src="' . $fs['js'] . 'calendar-setup.js"></script>
      <!-- /Popup Calendar Scripts -->';
        $css = "@import url(" . $fs['css'] . "cal.css);";
      
        
        $programme = new Programme;
        
        if (!isset ($_GET['edit']))
        {
            $form = $programme->addProgItemForm();
        }
        
        if (isset ($_GET['edit']) && isset ($_GET['id']))
        {
            
            $id = $_GET['id'];
            
            $programme->sql_where = "WHERE id = '{$id}'";
            $result = $programme->getProgramme();
            
            $row = mysql_fetch_assoc( $result );
            
            $form = $programme->editProgItemForm( $row );
        }
        $body .= $programme->displayProgramme( 'edit' ) . $form;
        
        $tpl =  $fs_root . 'template/admin.tpl';
        include_once( $fs_root . 'inc/template.php' );
        print $html;
    }
