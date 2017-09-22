<?php
/**
 *  File management class for serving downloadable files, and uploading
 *  new files
 *
 *  @author  Richard Perry (richard@perrymail.me.uk)
 *  @version 1.0
 *  @package FreeSpirit
 *  @filesource
 */

/**
 *  Checks if the script is being accessed from within a page, otherwise
 *  kills the execution
 */
if( !defined('IN_FSW') ) {
    die();
}


class File
{
     
    // variables

    private $html;
    private $sql_where;
    private $sql_order = 'ORDER BY title ASC';
     
     
     
    /********************************
     *                              *
     *       Display Methods        *
     *                              *
     * Edit these to change the way *
     * file listings are displayed  *
     *                              *
     ********************************/ 
    
    /**
     * Queries the database to get a list of files available to download 
     * given the category, check whether a title is required, then generates
     * the required HTML for output to the browser
     *
     * @param  string  $cat      the category of the download
     * @param  string  $class    class name for styling the output
     * @param  integer $title    1 or 0 - should there be a title or not
     * @return string  $html     html output for the browser
     */
    public function displayDownloads( $cat, $class, $title = NULL, $sep = false )
    {
        global $fs, $separator;
        
        // get the list of downloads from the database
        $this->sql_where = "WHERE cat LIKE '%$cat%'";
        $result = $this->getFiles();

        // Check if there are any results, if not, return
        if ( mysql_num_rows( $result ) == 0 ) {
            $this->html = "";
        } else {        
            $this->html = "
            <div class='$class'>
                   ";
            $this->html .= ($title == NULL)
                ? '<h3>Downloads</h3>'
                : '<h4>' . $title . '</h4>';
            while ($row = mysql_fetch_assoc( $result )) {
                $this->html .= "
                <a href='{$fs['files']}{$row['link']}' title='
                {$row['title']}'>
                <img src='{$fs['img']}{$row['doctype']}.jpg' />
                &nbsp;&nbsp;{$row['title']}
                </a><br />";
            }
            $this->html .= "
            </div>";

            // Add the rowing image separator if required
            if ( $sep ) {
                $this->html .= $separator;
            }
        }

        return $this->html;
    }
    
    
    
    /**
     * Display a table of the files stored on the db with edit and delete
     * options
     * 
     * Queries the database to find all files that are not categorised as 
     * deleted, then orders the results by the category. Generated the HTML
     * output of the table to include links for editing the items, as well
     * as deleting the items. The delete button includes a small javascript
     * check to ensure the button wasn't clicked by accident.
     *
     * @global array   $fs    File locations within FreeSpirit site
     * @return string  $html  html output for display
     */
    public function displayDownloadAdmin()
    {
        global $fs;
        
        // get the list of downloads from the database
        $this->sql_where = "WHERE cat != 'deleted'";
        $this->sql_order = "ORDER BY cat ASC";
        $files = $this->getFiles();
        
        // generate html output
        $this->html = "
        <h3>Downloadable Files</h3>
        <table class='admin files'>
        <th>id</th>
        <th>Title</th>
        <th>Filename</th>
        <th>Category</th>
        <th>Doc Type</th>
        <th>Edit</th>
        <th>Del</th>";
        
        while ( $row = mysql_fetch_assoc( $files )) {
            $this->html .= "
            <tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['link']}</td>
            <td>{$row['cat']}</td>
            <td>{$row['doctype']}</td>
            <td>
            <a href='?edit&amp;id={$row['id']}'>
            <img src='{$fs['img']}edit.png' alt='Edit' />
            </a>
            </td>
            <td>
            <a href='{$fs['admin']}process.php?deleteFile&amp;id={$row['id']}' 
             onclick=\"return confirm('Are you sure you want to delete this file?')\">
            <img src='{$fs['img']}delete.png' alt='Delete' />
            </a>
            </td>
            </tr>";
        }
        
        $this->html .= "
            </table>";
        
        return $this->html;        
    }
    
    
    
    
    /**
     * Generates a form for adding a new file to the site
     * 
     * Generates a form, using html, for uploading new files to the sites
     * downloads section. A simple javascript hides the form from view, and
     * shows a link to display the form. The form allows a maximum filesize
     * of 2MB and lists the available categories the file can fit into.
     * 
     * @global array   $dl    Download categories
     * @global array   $fs    FreeSpirit directory paths
     * @return string  $html  html output of the form
     */
    public function displayAddFileForm()
    {
        global $dl, $fs;
        
        $this->html = "
        <h4 class='adminForm'>Add Files</h4>
        <span id='show' class='showhide'>
        <a href='' onclick='showForm(\"addFile\"); return false;'>[+]</a>
        </span>
        <span id='hide' class='showhide' style='display: none'>
        <a href='' onclick='hideForm(\"addFile\"); return false;'>[-]</a>
        </span>
        <form enctype='multipart/form-data' method='post' class='admin' id='addFile' 
         action='{$fs['admin']}process.php?addFile' style='display: none'>
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='text' value='' id='title' name='title' />
        <span class='adminSpan'>Category</span>
        <select class='adminSelect' name='cat'>";
        foreach ($dl as $value => $title) {
            $this->html .= "
            <option value='$value'>$title</option>";
        }
        $this->html .= "
        </select>
        <span class='adminSpan'>File</span>
        <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
        <input type='file' name='upload' id='upload' />
        <input type='submit' name='addFile' id='addFile' value='Submit' />
        </form>";
         
        return $this->html;
    }
    
    
    
    
    /**
     * Generates a form for editing the category of files on the system
     * 
     * @global array   $dl    Download categories
     * @global array   $fs    FreeSpirit directory paths
     * @return string  $html  html output of the form
     */
    public function displayEditFileForm( $id )
    {
        global $dl, $fs;
        
        // get the details for the file to be editted
        $this->sql_where = 'WHERE id = ' . $id;
        $file = $this->getFiles();
        
        $row = mysql_fetch_assoc( $file );
        
        $this->html = "
        <h4 class='adminForm'>Edit Files</h4>
        <span id='show' class='showhide'>
        <a href='' onclick='showForm(\"editFile\"); return false;'>[+]</a>
        </span>
        <span id='hide' class='showhide' style='display: none'>
        <a href='' onclick='hideForm(\"editFile\"); return false;'>[-]</a>
        </span>
        <form method='post' class='admin' id='editFile' 
          action='{$fs['admin']}process.php?editFile' style='display: none'>
        <input type='hidden' value='{$row['id']}' id='id' name='id' />
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='text' value='{$row['title']}' id='title' name='title' />
        <span class='adminSpan'>Category</span>
        <select class='adminSelect' name='cat'>";
        foreach ($dl as $value => $title) {
            if ( $value == $row['cat']) {
                $this->html .= "
            <option value='$value' selected='selected'>$title</option>";
            }
            $this->html .= "
            <option value='$value'>$title</option>";
        }
        $this->html .= "
        </select>
        <span class='adminSpan'>File: {$row['link']}</span>
        <input type='submit' name='editFile' id='editFile' value='Submit' />
        </form>";
         
        return $this->html;
    }
    
    
    
    
    /****************************
     *                          *
     *     Public Functions     *
     *                          *
     ****************************/

    /**
     * Uploads files to the server and adds a record for them in the
     * database
     * 
     * The uploaded file and it's category are submitted by the upload 
     * form (displayUploadForm) and the mime type is checked. This is not
     * a security check, as the form can only be viewed/used by admin 
     * users. The temporary file is checked to ensure it has uploaded, and
     * is then moved the the file store directory. Once complete, the file
     * details are added to the database (setFiles) so they can be viewed. 
     *
     * @param  array   $file   associative array holding uploaded file details
     * @param  string  $cat    the category that the file is linked to
     * @param  string  $title  the user readable title for the file
     * @return mixed           return the results of setFile
     */ 
    public function uploadFiles( $file, $cat, $title )
    {
        global $fs;
        
        $dir = $fs['files'];
        $file = basename($file['upload']['name']);
        $link = $dir . $file;
        
        switch($file['upload']['type'])
        {
            case 'application/msword':
                $doctype = 'word';
                break;
            
            case 'application/pdf':
                $doctype = 'pdf';
                break;
            
            default:
                $error = 'Mime type ' . $file['upload']['type'] . ' not supported';
                return $error;                
        }
        
        if ( !is_uploaded_file( $file['upload']['tmp_name'] ) ) {
            return 'Upload error with file ' . $file;
        }
        if ( !move_uploaded_file( $file['upload']['tmp_name'], $link )) {
            return 'Error uploading file' . $file;
        }
        
        $return = $this->setFile( $title, $file, $cat, $doctype );
        
        return $return;
    }
    
    
    
    function updateFile( $data )
    {
        global $tbl;
        
        // extract the post data into individual strings
        extract( $data );
        
        $sql = "UPDATE {$tbl['dl']}
                SET title = '$title',
                    cat = '$cat'
                WHERE id = $id";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 'Error updating file ' . $title . ' in database';
        }

        return 'File ' . $title . ' updated successfully';
    }
        
    
    
    /**
     * Updates the database to show the item as deleted
     * 
     * Changes the category of the file record, with the specified id, 
     * to deleted so that the file does not show up on a list of files
     * available to download. The file itself is not deleted, and the 
     * database record for it is also not deleted in case there is a 
     * need for the file again in the future.
     *
     * @param  integer  $id    id of the item to be deleted
     * @return string   $html  html output for browser display
     */
    public function deleteFile( $id )
    {
        global $tbl;
        
        $sql = "UPDATE {$tbl['dl']}
                SET cat = 'deleted'
                WHERE id = {$id}";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 'Cannot delete file id ' . $id . ' error connecting to database';
        }

        return 'File id ' . $id . ' deleted successfully';
    }
    

    
    /**
     * Reads through a directory and displays the details in a table
     *
     * @param  string $folder   folder to list
     * @param  string $hide     hide the table?
     * @return string           HTML output
     */
    public function showLocalFiles( $folder = 'files', $hide = false )
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $folder . '/';
        
        if(is_dir($path)) {
            $level = count(explode( '/', $folder )) - 1;
            switch ($hide) {
                case false:
                    $table = "<table id='files'>\n";
                    break;
                case true:
                    $table = "<table id='1" . $folder . "' class='dir " . $level . "'>\n";
                    break;
            }
            
            $dir = opendir($path);
            
            while(($file = readdir($dir)) !== FALSE) {
		  if (($file == '.')||($file == '..')) {}
                elseif (is_dir( $path . $file )) {
                    $directory = $folder . '/' . $file;
                    $colspan = 4 + $level;
                    $table .= "<tr>\n";
                    for( $i = 1; $i <= $level; $i++ ) {
                        $table .= "<td class='space'>&nbsp;</td>\n";
                    }
                    $table .= "<td valign='top'>\n<img src='/images/ext/folder16.png' />\n</td>\n" . 
                        "    <td colspan='" . $colspan . "'><a id='dir' title='" . $file . "'>" . 
                        $file . "</a>\n" .
                        $this->showLocalFiles( $directory, true ) . 
                        "    </td>\n</tr>\n";
                } else {
                    $files .= "<tr>\n";
                    for( $i = 1; $i <= $level; $i++ ) {
                        $files .= "<td class='space'>&nbsp;</td>\n";
                    }
                    $files .= "<td><img src='/images/ext/" . substr(strrchr($file, '.'), 1) . "16.png' />" . 
                        "</td>\n<td class='filename'><a title='" . $file . "' href='/" . $folder . 
                        "/" . $file . "'>" . $file . "</a></td>\n<td class='filesize'>" . 
                        filesize( $path . $file ) . "B</td>\n<td class='filetype'>" . 
                        ucfirst(substr(strrchr($file, '.'), 1)) . " File</td>\n<td class='filemodified'>" . 
                        date( "d/m/Y H:i", filemtime( $path . $file )) . "</td>\n</tr>\n";
                }
            }
            
            $table .= $files . "</table>\n";
        }
        
        return $table;    

    }
    
    
    
    /*****************************
     *                           *
     *     Private Functions     *
     *                           *
     *****************************/ 
     
    /**
     * Gets a list of the files stored in the database
     *
     * @global array   $tbl      Tables within the database
     * @return array   $result   SQL query result data
     */
    private function getFiles()
    {
        global $tbl;
        
        $sql = "SELECT *
                FROM {$tbl['dl']}
                {$this->sql_where} 
                {$this->sql_order}";
        $result = mysql_query( $sql );

        return $result;
    }
     
     
    /**
     * Adds a record for the file to the database
     *
     * @param  string $title    name of the file
     * @param  string $link     link to the file location
     * @param  string $cat      category the file sits in
     * @param  string $doctype  mime type of the file for displaying icons
     * @return string           HTML output
     */
    private function setFile( $title, $link, $cat, $doctype )
    {
        global $tbl;

        $sql = "INSERT INTO {$tbl['dl']}
                    (title,
                    link,
                    cat,
                    doctype)
                VALUES ('{$title}',
                    '{$link}',
                    '{$cat}',
                    '{$doctype}'')";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 'Error adding file ' . $link . ' to database';
        }

        return 'File ' . $title . ' uploaded successfully';
    }
    
    
        
}
