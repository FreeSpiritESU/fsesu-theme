<?php
/**
 *  A class for handling a news system
 *
 *  @author  Richard Perry (richard@perrymail.me.uk)
 *  @version 1.0
 *  @package FreeSpirit
 *  @example ../examples/newsExample.php  Example of news class usage
 */

/**
 *  Checks if the script is being accessed from within a page, otherwise
 *  kills the execution
 */
if( !defined('IN_FSW') )
{
    die();
}


class News
{
     
    // variables
     
    var $news;       // output variable
    var $sql_where = "WHERE type = 'mainnews'";  // for forming the sql query string
    var $sql_limit;  // for forming the sql query string
    var $num;        // storing the number of records found
     
     
     
    //functions
     
    /**
     * A function for querying the database to get the news items - used by a
     * number of the other functions
     *
     * @global array $tbl  Tables within the database
     * @return array
     */
    function getNews()
    {
        global $tbl;

        $sql = "SELECT *
                FROM {$tbl['news']}
                {$this->sql_where}
                ORDER BY date DESC
                {$this->sql_limit}";
        $result = mysql_query ( $sql ) or die('Failed to find news'.mysql_error());
        $this->num = mysql_num_rows( $result );

        if (!$result) {
            return "Error connecting to the database. Please contact administrator";
        }

        return $result;
    }
     
     
     
    /**
     * A function for adding news items.
     *
     * @param  string  $title    Title of the news item
     * @param  string  $summary  Summary for displaying on the front page
     * @param  string  $article  The complete news article
     * @param  string  $type     mainnews or whatsnew (long or one line news item)
     * @global array   $tbl      Tables within the database
     * @return boolean
     */
    function setNews( $title, $summary, $article, $type = 'mainnews' )
    {
        global $tbl;

        $sql = "INSERT INTO {$tbl['news']}
                    (title,
                    date,
                    summary,
                    article,
                    type)
                VALUES ('{$title}',
                    CURDATE(),
                    '{$summary}',
                    '{$article}',
                    '{$type}')";
        print $sql;
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
    /**
     * Amend details of a news item
     *
     * @param  integer $id       ID of news item being updated
     * @see    setNews()         for $title, $summary & $article
     * @global array   $tbl      Tables within the database
     * @global array   $fs       Directory paths
     * @global string  $fs_root  Root path
     * @global string  $gallery  URL of photobucket gallery
     * @return boolean
     */
    function updateNews( $id, $title, $summary, $article )
    {
        global $tbl, $fs, $fs_root, $gallery;

        // add the date revised to the title
        $title .= '<i>(revised '. date('j.n.y') .')</i>';

        // replace certain text items with placeholders
        $replace = array(
            '{images}'        => '../images/', 
            '{fs_root}'       => '../', 
            '{gallery}'       => $gallery, 
            '{files}'         => '../files/');
        $summary = str_replace( array_values($replace), array_keys($replace), $summary );
        $article = str_replace( array_values($replace), array_keys($replace), $article );

        $sql = "UPDATE {$tbl['news']}
                SET title = '$title',
                    summary = '$summary',
                    article = '$article'
                WHERE id = $id";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
    /**
     * Mark a news item as deleted so that it is no longer listed
     *
     * @param  integer  $id  ID of the item to be deleted
     * @global array    $tbl Tables within the database
     * @return boolean
     */
    function deleteNews( $id )
    {
        global $tbl;
        $sql = "UPDATE {$tbl['news']}
                SET type = 'deleted'
                WHERE id = {$id}";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
    /**
     * Display the news according to the type chosen (types described below)
     *
     * @param  integer $type       Number denoting the chosen display type
     * @return string  $this->news
     */
    function displayNews( $type = 0 )
    {
        // check to see if a specific news item is being requested
        if (isset ($_GET['id'])) {
            $id = $_GET['is'];
            $this->sql_where = "WHERE id = '{$id}'";
            $type = 2;
        }
        // check if all news is being requested
        elseif (isset ($_GET['news'])) {
            $type = 1;
        }

        // clear the news variable ready for collating the latest news items
        $this->news = '';

        switch ($type)
        {
            case 0:
                // displays the 5 most recent stories, with the first article being displayed
                // in full the other four displaying only a summary
                $this->sql_limit = 'LIMIT 5';
                $this->displayNewsArticle();
                $this->displayNewsSummaries();
                break;

            case 1:
                // displays summaries for all news items
                $this->displayNewsSummaries();
                break;

            case 2:
                // display the full news article
                $this->displayNewsArticle();
                break;

            case 3:
                // displays the 'whats new' items
                $this->displayWhatsNew();
                break;

            default:
                $this->sql_limit = 'LIMIT 5';
                $this->displayNewsArticle();
                $this->displayNewsSummaries();
                break;
        }

        return $this->news;
    }
     
     
     
    /**
     * Display the summaries of the main news stories, with a link to read the
     * whole article.
     *
     * @return string $this->news  HTML code of the news summaries
     */
    function displayNewsSummaries()
    {
        // fetch the news
        $news = $this->getNews();
        while ($row = mysql_fetch_array( $news )) {
            $date = date ('l d F Y',strtotime($row['date']));
            $this->news .= "
             <div class='news summary'>
                 <blockquote>" . $date . "</blockquote>
                 <h4>" . $row['title'] . "</h4>
                 <p>" . $row['summary'] . "</p>
                 <small><a href='?id=" . $row['id'] . "' class='blue'>Click here to read more</a></small>
            </div>";
            $type = $row['type'];
        }

        // clean placeholders and non display characters (i.e. '£')
        $this->news = $this->cleanNews( $this->news );
        $this->displayNewsEdit( $type );

        return $this->news;
    }
     
     
     
    /**
     * Display the articles of the main news stories
     *
     * @return string $this->news  HTML code of the news stories
     */
    function displayNewsArticle()
    {
        // fetch the news
        $news = $this->getNews();
        while ($row = mysql_fetch_array( $news )) {
            $date = date ('l d F Y',strtotime($row['date']));

            $this->news .= "
            <div class='news'>
               <blockquote>" . $date . "</blockquote>
               <h4>" . $row['title'] . "</h4>
               <p>" . $row['article'] . "</p>
            </div>";
            $type = $row['type'];
        }

        // clean placeholders and non display characters (i.e. '£')
        $this->news = $this->cleanNews( $this->news );
        $this->displayNewsEdit( $type );

        return $this->news;
    }
     
     
     
    /**
     * Display the latest 'Whats News' news stories
     *
     * @return string $this->news  HTML code of the news stories
     */
    function displayWhatsNew()
    {
        // chose only the one line 'whatsnew' news items
        $this->sql_where = "WHERE type = 'whatsnew'";

        // limit the selection to the 8 latest items
        $this->sql_limit = 'LIMIT 8';

        // fetch the news items
        $news = $this->getNews();

        $this->news .= "
         <h3>What's New</h3>";

        while ( $row = mysql_fetch_array( $news )) {
            $this->news .= "
            <p>{$row['title']}</p>";
            $type = $row['type'];
        }

        // clean placeholders and non display characters (i.e. '£')
        $this->news = $this->cleanNews( $this->news );
        $this->displayNewsEdit( $type );

        return $this->news;
    }
     
     
     
    /**
     * Cleans out the placeholders and characters that don't display correctly
     *
     * @param  string $news      The HTML of the news items that need 'cleaning'
     * @global string $gallery   URL of the photobucket picture site
     * @global array  $fs        Paths to fs directories
     * @global string $fs_root   Root path
     * @return string $news      The cleaned news HTML
     */
    function cleanNews( $news )
    {
        global $gallery, $fs, $fs_root, $downloads;

        // replace the placeholders and bad charactes
        $replace = array(
             '{images}'        => $fs['img'], 
             '{fs_root}'       => $fs_root, 
             '{gallery}'       => $gallery, 
             '{files}'         => $fs['files'],
             '{downloads}'     => $downloads,
             '£'               => '&pound;');
        $news = str_replace( array_keys($replace), array_values($replace), $news );

        return $news;
    }
     
     
     
    /**
     * Display a list of the news articles of a given type with edit and delete
     * options
     *
     * @param string $type  Main news article or headline What's New item
     * @return string       HTML output
     */
    function listNews( $type )
    {
        global $fs;

        // select on the type requested
        $this->sql_where = "WHERE type = '{$type}'";

        $news = $this->getNews();

        $list = "
            <h3>News</h3>
            <table class='admin news'>
               <th>id</th>
               <th>Date</th>
               <th>Title</th>
               <th>Edit</th>
               <th>Del</th>
               ";

        while ( $row = mysql_fetch_assoc( $news )) {
            $date = date ('d M Y',strtotime($row['date']));
            $list .= "
            <tr>
            <td>{$row['id']}</td>
            <td style='width: 85px'>{$date}</td>
            <td>{$row['title']}</td>
            <td>
            <a href='?edit&amp;id={$row['id']}'>
            <img src='{$fs['img']}edit.png' alt='Edit' />
            </a>
            </td>
            <td>
            <a href='{$fs['admin']}process.php?deleteNews&amp;id={$row['id']}'>
            <img src='{$fs['img']}delete.png' alt='Delete' />
            </a>
            </td>
            </tr>";
        }

        $list .= "
            </table>";

        return $list;
    }
     
     
     
     
    /**
     * Display the form for adding news to the site
     *
     * @param string $type  Main news article or headline What's New item
     * @return string       HTML Output
     */
    function addNewsForm( $type )
    {
        global $fs;

        $addNewsForm = "
        <h4 class='adminForm'>Add News</h4>
        <span id='show' class='showhide'>
        <a href='' onclick='showForm(\"addNews\"); return false;'>[+]</a>
        </span>
        <span id='hide' class='showhide' style='display: none'>
        <a href='' onclick='hideForm(\"addNews\"); return false;'>[-]</a>
        </span>
        <form method='post' class='admin' id='addNews' action='{$fs['admin']}process.php?addNews&amp;type={$type}' style='display: none'>
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='text' value='' id='title' name='title' />";
         
        if ( $type == 'mainnews' ) {
            $addNewsForm .= "
               <span class='adminSpan'>Summary</span>
               <textarea class='adminTextarea' id ='summary' name='summary' rows='3' cols='50'></textarea>
               
               <span class='adminSpan'>Article</span>
               <textarea class='adminTextarea' id ='article' name='article' rows='10' cols='50'></textarea>";
        }

        $addNewsForm .= "
               <input type='submit' name='addNews' id='addNews' value='Submit' />
            </form>";
         
        return $addNewsForm;
    }
     
     
     
     
    /**
     * Display form for editing news items
     *
     * @param integer $id        id of the news item to be edited
     * @param string  $title     current title of the news item
     * @param string  $summary   current summary of the news item
     * @param string  $article   current article content
     * @param string  $type      Main news article or headline What's New item
     * @return string            HTML output
     */
    function editNewsForm( $id, $title, $summary, $article, $type )
    {
        global $fs;
        $summary = $this->cleanNews( $summary );
        $article = $this->cleanNews( $article );

        $editNewsForm = "
        <h4 class='adminForm'>Edit News</h4>
        <form method='post' class='admin' action='{$fs['admin']}process.php?editNews&amp;type={$type}'>
        <span class='adminSpan'>Title</span>
        <input class='adminInput' type='hidden' value='{$id}' id='id' name='id' />
        <input class='adminInput' type='text' value='{$title}' id='title' name='title' />";
         
        if ( $type == 'mainnews' ) {
            $editNewsForm .= "
            <span class='adminSpan'>Summary</span>
            <textarea class='adminTextarea' id ='summary' name='summary' rows='3' cols='50'>{$summary}</textarea>
             
            <span class='adminSpan'>Article</span>
            <textarea class='adminTextarea' id ='article' name='article' rows='10' cols='50'>{$article}</textarea>";
        }

        $editNewsForm .= "
               <input type='submit' name='editNews' id='editNews' value='Submit' />
            </form>";

        return $editNewsForm;
    }
     
     
     
    /**
     * If the user if an administrator, display an edit link by the news
     *
     * @param string $type  Main news article or headline What's New item
     * @return string       HTML output
     */
    function displayNewsEdit( $type )
    {
        global $session, $fs;
        if ( $session->userdata['userlevel'] > 5 ) {
            $this->news .= "
            <small class='edit'><a href='{$fs['admin_news']}?type={$type}'>[Edit..] </a></small>";
        }

        return $this->news;
    }
}
