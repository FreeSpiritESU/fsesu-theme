<?php
define('IN_FSW', true);
$fs_root = './../';

require_once( $fs_root . 'inc/common.php' );

$page_title .= '>> Administration Control Panel >> Downloads';

// check that the user has the correct userlevel to access this page
if ($session->userdata['userlevel'] < 5) {
    $body = file_get_contents( $fs_root . 'error403_body.htm' );

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
    die();
} else {
    // include the main class for dealing with files and instantiate it
    require_once( $fs_root . 'inc/classes/File.php' );
    $files = new File;
    
    // add the javascript for hiding the addFile form
    $extra_head_info = "
        <script type='text/javascript' src='{$fs['js']}formHide.js'> 
        </script>";
    
    // check for the edit parameter, if not set, display the Add File Form
    if (!isset ($_GET['edit'])) {
        $form = $files->displayAddFileForm();
    }
    
    // if the edit parameter is set then display the Edit File Form
    if (isset ($_GET['edit']) && isset ($_GET['id'])) {
        $id = $_GET['id'];
        $form = $files->displayEditFileForm($id);
    }
    
    $body .= $files->displayDownloadAdmin() . $form;

    $tpl =  $fs_root . 'template/admin.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
}

