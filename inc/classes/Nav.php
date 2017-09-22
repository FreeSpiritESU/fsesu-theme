<?php
/**
 *  A class for handling the site navigation
 *
 *  @author  Richard Perry (richard@perrymail.me.uk)
 *  @version 1.0
 *  @package FreeSpirit
 *
 */

/**
 *  Checks if the script is being accessed from within a page, otherwise
 *  kills the execution
 */
if( !defined('IN_FSW') )
{
    die();
}


class Nav
{
    // Variables
    var $nav;           // Output variable
    var $sql_where;     // MySQL WHERE statement variable
     
    /**
     * A function for querying the database to get the navigation items - used
     * by a number of the other functions
     */
    function getNav()
    {
        global $tbl;
        $sql = "SELECT *
                FROM {$tbl['nav']}
                {$this->sql_where}
                ORDER BY ordering ASC";
        $result = mysql_query( $sql );

        if (!$result) {
            return "Error connecting to the database. Please contact administrator";
        }
        
        return $result;
    }
     
     
     
     
    /**
     * displayNav - A function for displaying the navigation menu at
     * the top of each page
     *
     * @param  string $id         sets whether the style should be an id or
     *                            class and defaults to id
     * @global string $fs_root    the root path of the site
     * @return string $this->nav  returns the formatted navigation list
     */
    function displayNav($id = 'id')
    {
        global $fs_root, $session;

        // select the top level navigation items
        $this->sql_where = 'WHERE level = 0
                            AND parent = -1';
        $top = $this->getNav();

        // organise them into a list
        $this->nav = "
        <ul {$id}='menu'>";

        // fetch the results of the query for the top level of links
        while ($row = mysql_fetch_array( $top )) {
            // extract the results into simpler variables
            extract( $row );
            $link_t = $link;
             
            // check if the link is internal, and if it is, add the root path to it
            $href = ($intext == 'int') ? $fs_root . $link_t : $link_t;
            $this->nav .= "
            <li><a href='" . $href . "' title=\"" . $name . "\">" . $name . "</a>";            
            
            // check to see if this item has any sub items
            $this->sql_where = "WHERE parent = " . $id . "
                               AND level = 1";
            $level1 = $this->getNav();
            $num = mysql_num_rows($level1);
            
             
            //if it does, create a new list for the sublevel menu
            if ($num > 0) {
                $this->nav .= "
               <ul>";
	         
                $menu = $id;
                
                while ($row = mysql_fetch_array( $level1 )) {
                    // extract the results into simpler variables
                    extract( $row );
                     
                    $href = ($intext == 'int') ? $fs_root . $link_t . $link : $link;
                    $this->nav .= "
               <li><a href='" . $href . "' title=\"" . $name . "\">" . $name . "</a></li>";
                }
                /**
		   * Check if this is the Members link and if a member is logged,
		   * if so, then add the relevant links to the menu
		   */
		        
		  if ($menu == 8 && $session->userdata['userlevel'] >= 5) {
		      $this->nav .= "
		 <li><a href='/members/forms.php' title='File Downloads'>File Downloads</a></li>";
	         }
                 
                $this->nav .= "
               </ul>
            ";
            }
             
            $this->nav .= "</li>";
        }

        $this->nav .= "
         </ul>";

        // return the navigation list
        return $this->nav;
    }
     
     
     
     
    /**
     * A function for adding a new link/menu item to the navigation table
     *
     * @param  string $name       Link name
     * @param  string $link       Link location
     * @param  string $ordering   Position of the link in the list
     * @param  string $level      Level at which the link appears
     * @param  string $parent     ID of the parent link
     * @param  string $intext     Whether the link is an internal or external one
     * @global array  $tbl        Array of the database tables
     * @return boolean            Returns 0 if failed and 1 if successful
     */
    function setLink( $name, $link, $ordering, $level, $parent, $intext )
    {
        global $tbl;
        
        $sql = "INSERT INTO {$tbl['nav']}
                    (name,
                    link,
                    ordering,
                    level,
                    parent,
                    intext)
                VALUES ('{$name}',
                    '{$link}',
                    '{$ordering}',
                    '{$level}',
                    '{$parent}',
                    '{$intext}')";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    /**
     * A function for updating a links/menu items
     *
     * @see setLink() for parameters, global variables and return value
     */
    function updateLink( $id, $name, $link, $ordering, $level, $parent, $intext )
    {
        global $tbl;
        $sql = "UPDATE {$tbl['nav']}
                SET name = '{$name}',
                    link = '{$link}',
                    ordering = '{$ordering}',
                    level = '{$level}',
                    parent = '{$parent}',
                    intext = '{$intext}'
                WHERE id = {$id}";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    /**
     * A function for moving a link/menu item from the main navigation table
     * into the deleted menu table. This is to ensure that any accidental
     * deletions can easily be recovered
     *
     * @param  integer $id  ID of the link to be deleted
     * @global array   $tbl Array of the database tables
     * @return boolean      Returns 0 if failed and 1 if successful
     */
    function deleteLink( $id )
    {
        global $tbl;

        /**
         * First get the details for the link to be deleted so that it can be added
         * to an INSERT query for the deleted items table
         */
        $this->sql_where = "WHERE id = {$id}";
        $delete = $this->getNav();

        $deleted = mysql_fetch_assoc( $delete );
        extract( $deleted );

        // Then add to the deleted items table
        $sql = "INSERT INTO {$tbl['nav_del']}
                    (name,
                    link,
                    ordering,
                    level,
                    parent,
                    intext)
                VALUES ('{$name}',
                    '{$link}',
                    '{$ordering}',
                    '{$level}',
                    '{$parent}',
                    '{$intext}')";
        $result = mysql_query( $sql );

        // and if it fails, return the function as failed
        if (!$result) {
            return 0;
        }

        // otherwise proceed with deleting the item for the navigation table
        $sql = "DELETE FROM {$tbl['nav']}
        WHERE id = {$id}";
        $result = mysql_query( $sql );

        // and return whether the deletion was successful or not
        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    /**
     * A function for displaying the form for adding a new link
     *
     * @global array  $fs          Array of fs folder paths
     * @return string $addLinkForm Return the formatted add form
     */
    function addLinkForm()
    {
        global $fs;

        $addLinkForm = "
        <h4 class='adminForm'>Add Link</h4>
        <span id='show' class='showhide'>
        <a href='' onclick='showForm(\"addLink\"); return false;'>[+]</a>
        </span>
        <span id='hide' class='showhide' style='display: none'>
        <a href='' onclick='hideForm(\"addLink\"); return false;'>[-]</a>
        </span>
        <form method='post' class='admin' id='addLink' style='display: none' action='{$fs['admin']}process.php?addLink'>
        <input class='adminInput' type='hidden' value='' id='id' name='id' />
         
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='text' value='' id='name' name='name' />
         
        <span class='adminSpan'>Link</span>
        <input class='adminInput' type='text' value='' id='link' name='link' />
         
        <span class='adminSpan'>Ordering</span>
        <input class='adminInput' type='text' value='' id='ordering' name='ordering' />
         
        <span class='adminSpan'>Parent</span>";

        // get a list of potential parent items
        $this->sql_where = "";
        $list = $this->getNav();

        $addLinkForm .= "
               <select class='adminSelect' name='parent'>";

        // and formulate into an options box
        while ( $parents = mysql_fetch_array( $list ) ) {
            $addLinkForm .= "
            <option value='{$parents['name']}' {$selected}>{$parents['name']}</option>";
        }
        $addLinkForm .= "
               </select>
               
               <span class='adminSpan'>Internal/External</span>
               <select class='adminSelect' name='intext'>
                  <option value='int' selected='selected'>Internal</option>
                  <option value='ext'>External</option>
               </select>
               
               <input type='submit' name='addLink' id='addLink' value='Submit' />
            </form>";

        // return the formatted form
        return $addLinkForm;
    }
     
     
     
     
    /**
     * A function for displaying the form for editing the links
     *
     * @param  integer $id  ID of the link item to be editted
     * @see    setLink() for other parameters
     * @return string  $editlinkform  Formatted form for editing a link
     */
    function editLinkForm( $id, $name, $link, $ordering, $level, $parent, $intext )
    {
        /**
         * Get an options list of the parent items with the correct parent selected
         */
        $optParents = $this->getParents( $parent );

        /**
         * Decide on the text and options to be displayed for the Internal/External
         * option box depending on the stored information
         */
        $intext_other = ( $intext == 'int' ) ? 'ext' : 'int';
        $intext_text = ( $intext == 'int' ) ? 'Internal' : 'External';
        $intext_text_other = ( $intext == 'int' ) ? 'External' : 'Internal';

        $editLinkForm = "
        <h3>Edit Link</h3>
        <form method='post' class='admin' action='{$fs['admin']}process.php?editLink&amp;id={$id}'>
        <input class='adminInput' type='hidden' value='{$id}' id='id' name='id' />
         
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='text' value='{$name}' id='name' name='name' />
         
        <span class='adminSpan'>Link</span>
        <input class='adminInput' type='text' value='{$link}' id='link' name='link' />
         
        <span class='adminSpan'>Ordering</span>
        <input class='adminInput' type='text' value='{$ordering}' id='ordering' name='ordering' />
         
        <span class='adminSpan'>Parent</span>
        {$optParents}
         
        <span class='adminSpan'>Internal/External</span>
        <select class='adminSelect' name='intext'>
        <option value='{$intext}' selected='selected'>{$intext_text}</option>
        <option value='{$intext_other}'>{$intext_text_other}</option>
        </select>
         
        <input type='submit' name='editLink' id='editLink' value='Submit' />
        </form>";

        // return the form
        return $editLinkForm;
    }
     
     
     
     
    /**
     * A function for getting a list of the links, displaying them in a select
     * box and highlighting the relevant parent item
     *
     * @param  integer $parent     The ID of the parent item to be selected
     * @return string  $optParents HTML of the options box
     */
    function getParents( $parent )
    {
        // clear the sql_where statement and get a list of navigation items
        $this->sql_where = "";
        $list = $this->getNav();

        // set the options box properties
        $optParents = "
               <select class='adminSelect' name='parent'>";

        /**
         * cycle through the list of parent items, adding them to the array, and
         * when the chosen parent item is found, ensure that it is marked as
         * selected
         */
        while ( $parents = mysql_fetch_array( $list ) ) {
            $selected = ( $parents['id'] == $parent ) ? "selected='selected'" : "";
            $optParents .= "
            <option value='{$parents['name']}' {$selected}>{$parents['name']}</option>";
        }
        $optParents .= "
               </select>";

        // return the options box
        return $optParents;
    }
     
     
     
     
    /**
     * A function for displaying the navigations links in a table for review and
     * editing
     *
     * @global string $fs_root the root path of the site
     * @global array  $fs      array of the fs folder paths
     * @return string $list    return a table listing the navigation items
     */
    function listNavigation()
    {
        global $fs_root, $fs;

        // get the top level of the navigation items first
        $this->sql_where = 'WHERE level = 0
                            AND parent = -1';
        $top = $this->getNav();

        // set up the table
        $list = "
            <h3>Navigation Links</h3>
            <table class='admin nav'>
               <th colspan='2'>Page</th>
               <th>Link</th>
               <th>Order</th>
               <th>Edit</th>
               <th>Del</th>
               ";

        // add top level navigation items to the table
        while ($main = mysql_fetch_array( $top )) {
            extract( $main );
             
            /**
             * if the link is internal display it, otherwise display a truncated
             * version of the main link
             */
            $href_t = ($intext == 'int') ? $link : substr( $link, 0, 30 ) . ' ...';
            $list .= "
            <tr>
            <td colspan='2'>{$name}</td>
            <td>{$href_t}</td>
            <td style='background: #eaeaea; text-align: center'>{$ordering}</td>
            <td>
            <a href='?edit&amp;id={$id}&amp;parent={$parent}'>
            <img src='{$fs['img']}edit.png' alt='Edit' />
            </a>
            </td>
            <td>
            <a href='{$fs['admin']}process.php?deleteLink&amp;id={$id}' onclick=\"return confirm('Are you sure you want to delete this link?')\">
            <img src='{$fs['img']}delete.png' alt='Delete' />
            </a>
            </td>
            </tr>";
             
            // check if there are sublevel links
            $this->sql_where = "WHERE parent = " . $id . "
                               AND level = 1";
            $level1 = $this->getNav();
            $num = mysql_num_rows($level1);
             
            // if there are, add them to the table and indent
            if ($num > 0) {
                while ($sub1 = mysql_fetch_array( $level1 )) {
                    extract( $sub1 );
                    $href = $href_t . $link;
                    $list .= "
                    <tr>
                    <td>&nbsp;</td>
                    <td>{$name}</td>
                    <td>{$href}</td>
                    <td style='text-align: center'>{$ordering}</td>
                    <td>
                    <a href='?edit&amp;id={$id}&amp;parent={$parent}'>
                    <img src='{$fs['img']}edit.png' alt='Edit' />
                    </a>
                    </td>
                    <td>
                    <a href='?delete&amp;id={$id}' onclick=\"return confirm('Are you sure you want to delete this link?')\">
                    <img src='{$fs['img']}delete.png' alt='Delete' />
                    </a>
                    </td>
                    </tr>";
                }
            }
        }

        $list .= "
         </table>";

        //return the table of links
        return $list;
    }
     
     
     
     
    /**
     * A function for displaying a list of pages with html body files for
     * editing with the content editor
     *
     * This function is designed to make the updating of site content easier for
     * the end user. Each page has the same main template for display, but a
     * static page includes the body of the page using a html file for ease of
     * editing. Within the navigation table, static pages are marked as having
     * html content. This function displays a list of these pages in the same
     * manner as the listNavigation() function above, but adds an edit link that
     * opens up the TinyMCE Javascript content editor programme.
     *
     * All pages not shown in this table are dynamic pages and therefore are
     * updated through one of the other administration function from one of the
     * other main site classes.
     *
     * @global string $fs_root   the root path of the site
     * @global array  $fs        an array of the fs folder paths
     * @return string $list      a formatted table of the links
     */
    function listHTMLPages()
    {
        global $fs_root, $fs;

        // get the top level of the navigation items first
        $this->sql_where = "WHERE level = 0
                          AND html = '1'
                          AND parent = -1
                          AND intext = 'int'";
        $top = $this->getNav();

        // define the table
        $list = "
            <h3>Content Editor</h3>
            <table class='admin nav'>
               <th colspan='2'>Page</th>
               <th>Link</th>
               <th>Edit</th>
               ";

        // add links to the table
        while ($main = mysql_fetch_array( $top )) {
            extract( $main );
            $link_t = $link;
             
            /**
             * Add index to the folder root links so that the correct file is edited
             */
            $page = str_replace( '/', '/index', $link );
             
            /**
             * Remove '.php' from each file name to ensure the html file is the one
             * edited by the content editor
             */
            $page = str_replace( '.php', '', $page );
             
            $list .= "
            <tr>
            <td colspan='2'>{$name}</td>
            <td>{$link_t}</td>
            <td>
            <a href='?edit&amp;page={$page}&#editor'>
            <img src='{$fs['img']}edit.png' alt='Edit' />
            </a>
            </td>
            </tr>";
             
            // then check if there are sublevel links
            $this->sql_where = "WHERE parent = " . $id . "
                               AND level = 1
                               AND html = '1'
                               AND intext = 'int'";
            $level1 = $this->getNav();
            $num = mysql_num_rows($level1);
             
            // if there are, add them to the table and indent
            if ($num > 0) {
                while ($sub1 = mysql_fetch_array( $level1 )) {
                    extract( $sub1 );
                    $link = $link_t . $link;
                     
                    // again remove the .php from the link
                    $page = str_replace( '.php', '', $link );
                     
                    $list .= "
                    <tr>
                    <td>&nbsp;</td>
                    <td>{$name}</td>
                    <td>{$link}</td>
                    <td>
                    <a href='?edit&amp;page={$page}&#editor'>
                    <img src='{$fs['img']}edit.png' alt='Edit' />
                    </a>
                    </td>
                    </tr>";
                }
            }
        }

        $list .= "
        <tr>
        <td colspan='2'>Contact Us</td>
        <td>contact.php</td>
        <td>
        <a href='?edit&amp;page=contact&#editor'>
        <img src='{$fs['img']}edit.png' alt='Edit' />
        </a>
        </td>
        </tr>
        <tr>
        <td colspan='2'>Error403</td>
        <td style='font-style: italic'>(displayed on unauthorised access attempts)</td>
        <td>
        <a href='?edit&amp;page=error403&#editor'>
        <img src='{$fs['img']}edit.png' alt='Edit' />
        </a>
        </td>
        </tr>
        </table>";

        // return the formatted table
        return $list;
    }
}