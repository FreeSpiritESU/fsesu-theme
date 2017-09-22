<?php
define('IN_FSW', true);
$fs_root = './../';
require_once( $fs_root . 'inc/common.php' );

$page_title .= '>> Administration Control Panel';

if ($session->userdata['userlevel'] < 5) {
    $body = file_get_contents( $fs_root . 'error403_body.htm' );

    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
    die();
} else {
    require_once( $fs_root . 'inc/classes/News.php' );
    require_once( $fs_root . 'inc/classes/Programme.php' );
    require_once( $fs_root . 'inc/classes/File.php' );

    $programme = new Programme;
    $news = new News;
    $navigation = new Nav;
    $file = new File;

    // News page processing
    if (isset ($_GET['addNews']) && isset ($_POST['addNews'])) {
        extract($_POST);
        $type = $_GET['type'];
         
        // check the news type
        if ($type == 'mainnews') {
            // convert line breaks from the text areas into <br /> tags and
            // replace £ with $pound;
            
            $summary = addslashes(str_replace( '£', '&pound;', nl2br($summary)));
            $article = addslashes(str_replace( '£', '&pound;', nl2br($article)));
        } else {
            $summary = $article = '';
        }
         
        $title = addslashes($title);
        
        if ($news->setNews( $title, $summary, $article, $type )) {
            header('refresh: 3; url=' . $fs['admin_news'] . '?type=' . $_GET['type']);
            $body .= "
            <h4 class='process'>News item '{$title}' added successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_news'] . '?type=' . $_GET['type']);
            $body .= "
            <h4 class='process'>Failed to add news item '{$title}'</h4>";
        }
    }

    if (isset ($_GET['editNews']) && isset ($_POST['editNews'])) {
        extract($_POST);
        
        $title   = addslashes( $title );
        $summary = addslashes( $summary );
        $article = addslashes( $article );
        
        if ($news->updateNews( $id, $title, $summary, $article )) {
            header('refresh: 3; url=' . $fs['admin_news'] . '?type=' . $_GET['type']);
            $body .= "
            <h4 class='process'>News item '{$title}' updated successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_news'] . '?edit&id=' . $id);
            $body .= "
            <h4 class='process'>Failed to update news item '{$title}'</h4>";
        }
    }

    if (isset ($_GET['deleteNews']) && isset ($_GET['id'])) {
        $id = $_GET['id'];
         
        if ($news->deleteNews( $id )) {
            header('refresh: 3; url=' . $fs['admin_news'] . '?type=' . $_GET['type']);
            $body .= "
            <h4 class='process'>News item '{$id}' deleted successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_news'] . '?type=' . $_GET['type']);
            $body .= "
           <h4 class='process'>Failed to delete news item</h4>";
        }
    }









    // Navigation admin processing
    if (isset ($_GET['addLink']) && isset ($_POST['addLink'])) {
        extract($_POST);
         
        /* get the level of the parent to ensure that the link is
         * positioned correctly */
        $nav->sql_where = "WHERE name = '{$parent}'";
        $result = $nav->getNav();
        $row = mysql_fetch_array( $result );
        $level = $row['level'] + 1;
         
        /* get the parent id for updating the database */
        $parent = $row['id'];
        
        $name = addslashes( $name );
        $link = addslashes( $link );
        
        if ($nav->setLink( $name, $link, $ordering, $level, $parent, $intext )) {
            header('refresh: 3; url=' . $fs['admin_content'] . '?edit&page=' . $link . '&#editor' );
            $body .= "
            <h4 class='process'>New menu item '{$name}' added successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_menu']);
            $body .= "
            <h4 class='process'>Failed to add new menu item '{$name}'</h4>";
        }
    }

    if (isset ($_GET['editLink']) && isset ($_POST['editLink'])) {
        extract($_POST);
         
        /* get the level of the parent to ensure that the link is positioned correctly */
        $nav->sql_where = "WHERE name = '{$parent}'";
        $result = $nav->getNav();
        $row = mysql_fetch_array( $result );
        $level = $row['level'] + 1;
         
        /* get the parent id for updating the database */
        $parent = $row['id'];
         
        $name = addslashes( $name );
        $link = addslashes( $link );
        
        if ($nav->updateLink( $id, $name, $link, $ordering, $level, $parent, $intext )) {
            header('refresh: 3; url=' . $fs['admin_menu']);
            $body .= "
            <h4 class='process'>Menu item '{$name}' updated successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_menu'] . '?edit&id=' . $id . '&parent=' . $parent);
            $body .= "
            <h4 class='process'>Failed to update menu item '{$name}'</h4>";
        }
    }

    if (isset ($_GET['deleteLink']) && isset ($_GET['id'])) {
        $id = $_GET['id'];
         
        if ($nav->deleteLink( $id )) {
            header('refresh: 3; url=' . $fs['admin_menu']);
            $body .= "
            <h4 class='process'>Menu item '{$title}' deleted successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_menu']);
            $body .= "
            <h4 class='process'>Failed to delete menu item '{$title}'</h4>";
        }
    }









    // Contents Page editor processing
    // check to see if a page has been edited and submitted
    if (isset ($_GET['updateContent']) && isset ($_GET['page'])
    && isset ($_POST['editor1'])) {
        $page = $_GET['page'];
        $htm_file = $fs_root . $page . '_body.htm';
        $php_file = $fs_root . $page . '.php';
        $content = $_POST['editor1'];
        
        // if the php file does not exist, create it
        if (!file_exists( $php_file )) {
            // if the page in within a directory change the fs_root to suit
            $root = (!preg_match( "/\//", $page )) ? './' : './../';
            $php_contents = "<?php
            define('IN_FSW', true);
            \$fs_root = '{$root}';
            require_once( \$fs_root . 'inc/common.php' );
             
            \$body = file_get_contents( \$fs_root . '{$page}_body.htm' );

            \$tpl =  \$fs_root . 'template/default.tpl';
            include_once( \$fs_root . 'inc/template.php' );
            print \$html; ";
            file_put_contents( $php_file, $php_contents );
        }
         
        /*
         * if the file cannot be updated take the user back to the
         * previous page. The file_put_contents will create the file
         * if it does not already exist
         */
        if (!file_put_contents( $htm_file, $content )) {
            header('refresh: 3; url=' . $fs['admin_content'] . '?edit&page=' . $page . '&#editor');
            $body .= "
            <h4 class='process'>Page '{$page}' failed to update</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_content']);
            $body .= "
            <h4 class='process'>Page '{$page}' successfully updated</h4>";
        }
    }










    // Programme admin processing
    if (isset ($_GET['addProgItem']) && isset ($_POST['addProgItem'])) {
        if ($programme->setProgItem( $_POST )) {
            header('refresh: 3; url=' . $fs['admin_prog']);
            $body .= "
            <h4 class='process'>New event '{$event}' added successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_prog']);
            $body .= "
            <h4 class='process'>Failed to add new event '{$event}'</h4>";
        }
    }

    if (isset ($_GET['editProgItem']) && isset ($_POST['editProgItem'])) {
        extract($_POST);
         
        if ($programme->updateProgItem( $_POST )) {
            header('refresh: 3; url=' . $fs['admin_prog']);
            $body .= '
           <h4 class="process">Event ' . $event . ' updated successfully</h4>';
        } else {
            header('refresh: 3; url=' . $fs['admin_prog'] . '?edit&id=' . $id);
            $body .= '
           <h4 class="process">Failed to update event ' . $event . '</h4>';
        }
    }

    if (isset ($_GET['deleteProgItem']) && isset ($_GET['id'])) {
        $id = $_GET['id'];
         
        if ($programme->deleteProgItem( $id )) {
            header('refresh: 3; url=' . $fs['admin_prog']);
            $body .= "
           <h4 class='process'>Event deleted successfully</h4>";
        } else {
            header('refresh: 3; url=' . $fs['admin_prog']);
            $body .= "
           <h4 class='process'>Failed to delete event</h4>";
        }
    }
    
    
    
    
    
    
    // Downloads processing
    if (isset ($_GET['addFile']) && isset ($_POST['addFile'])) {
        header('refresh: 3; url=' . $fs['admin_dl']);
        $cat = $_POST['cat'];
        $title = $_POST['title'];
        $body .= $file->uploadFiles( $_FILES, $cat, $title );
    }
    
    if (isset ($_GET['editFile']) && isset ($_POST['editFile'])) {
        header('refresh: 3; url=' . $fs['admin_dl']);
        $data = $_POST;
        $body .= $file->updateFile( $data );
    }
    
    if (isset ($_GET['deleteFile']) && isset ($_GET['id'])) {
        $id = $_GET['id'];
        header('refresh: 3; url=' . $fs['admin_dl']);
        $body .= $file->deleteFile( $id );
    }

    $tpl =  $fs_root . 'template/admin.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
}
