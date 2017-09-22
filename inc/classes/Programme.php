<?php
/*
 *  Filename:      Programme.php
 *  Author:        Richard Perry (richard@perrymail.me.uk)
 *  Version:       1.0.0.5 (29.08.2014)
 *  Description:   A class for handling a groups programme
 *  Functions:
 *  Usage:
 */
if( !defined('IN_FSW') )
{
    die();
}

class Programme
{
     
    // variables
     
    var $sql_where;
    var $sql_limit;
    var $sql_order = 'ORDER BY start ASC';
    var $curTerm;
    var $lastTerm;
    var $lastTermYear;
    var $nextTerm;
    var $nextTermYear;
    var $term;
     
     
     
    //functions
     
       
    /*
     * programme() is the class constructor and so is called when the
     * class is initiated. It sets the values for the current, next and
     * last term variables based on the current day.
     */
    function programme()
    {
        if ( strtotime( date( 'd F Y') ) < easter_date( date( 'Y' ) ) ) {
            $this->curTerm  = '1';
            $this->lastTerm = '3';
            $this->nextTerm = '2';
        }

        if ( strtotime( date( 'd F Y') ) > easter_date( date( 'Y' ) )
        && strtotime( date( 'd F Y') ) < strtotime( '15 August ' . date( 'Y' ) ) ) {
            $this->curTerm  = '2';
            $this->lastTerm = '1';
            $this->nextTerm = '3';
        }

        if ( strtotime( date( 'd F Y') ) > strtotime( '15 August ' . date( 'Y' ) ) ) {
            $this->curTerm  = '3';
            $this->lastTerm = '2';
            $this->nextTerm = '1';
        }
    }

     
     
     
    function getProgramme()
    {
        global $tbl;
        $sql = 'SELECT *
                FROM '.$tbl['cal'].' '.
                $this->sql_where.' '.
                $this->sql_order.' '.
                $this->sql_limit;
        $result = mysql_query( $sql );

        return $result;
    }
     
     
     
     
    function setProgItem( $row )
    {
        global $tbl;
        extract( $row );
        
        $event    = addslashes( $event );
        $details  = addslashes( $details );
        $location = addslashes( $location );
        $price    = str_replace( '£', '&pound;', $price );
        
        $sql = "INSERT INTO {$tbl['cal']}
                 (start, 
                  finish, 
                  event, 
                  details,
                  category,
                  price,
                  location,
                  link,
                  term) 
               VALUES (STR_TO_DATE('{$start}', '%d/%m/%Y'), 
                  STR_TO_DATE('{$finish}', '%d/%m/%Y'), 
                  '{$event}', 
                  '{$details}',
                  '{$category}',
                  '{$price}',
                  '{$location}',
                  '{$link}',
                  '{$term}')";
        
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    function updateProgItem( $row )
    {
        global $tbl;
        extract( $row );

        $event    = addslashes( $event );
        $details  = addslashes( $details );
        $location = addslashes( $location );
        $price    = str_replace( '£', '&pound;', $price );

        $sql = "UPDATE {$tbl['cal']}
                SET start = STR_TO_DATE('{$start}', '%d/%m/%Y'), 
                    finish = STR_TO_DATE('{$finish}', '%d/%m/%Y'), 
                    event = '{$event}', 
                    details = '{$details}',
                    category = '{$category}',
                    price = '{$price}',
                    location = '{$location}',
                    link = '{$link}',
                    term = '{$term}' 
                WHERE id = {$id}";
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    function deleteProgItem( $id )
    {
        global $tbl;
        $sql = 'DELETE FROM ' . $tbl['cal'] . '
                WHERE id = ' . $id;
        $result = mysql_query ( $sql );

        if (!$result) {
            return 0;
        }

        return 1;
    }
     
     
     
     
    function addProgItemForm()
    {
        global $fs, $terms;

        $list = $this->getCategories();
        while ( $cats = mysql_fetch_array( $list ) ) {
            $catList .= "
            <option value='{$cats['category']}'>{$cats['category']}</option>";
        }
        foreach ($terms as $t => $i) {
            $term_options .= "
            <input class='adminRadio' type='radio' name='term' value='$i' />
            <span class='adminSpanRadio'>$t</span>";
        }
        $addProgItemForm = "
        <h4 class='adminForm'>Add Programme Item</h4>
        <span id='show' class='showhide'>
        <a href='' onclick='showForm(\"addProgItem\"); return false;'>[+]</a>
        </span>
        <span id='hide' class='showhide' style='display: none'>
        <a href='' onclick='hideForm(\"addProgItem\"); return false;'>[-]</a>
        </span>
        <form method='post' class='admin' id='addProgItem' style='display: none' action='{$fs['admin']}process.php?addProgItem'>
        <span class='adminSpan'>Start Date</span>
        <div class='date'><input class='adminInput date' type='text' value='' id='start' name='start' /><button id='start_date'>...</button></div>
        <script type='text/javascript'>
        Calendar.setup(
        {
            inputField  : 'start',        // ID of the input field
            ifFormat    : '%d/%m/%Y',     // the date format
            button      : 'start_date',   // ID of the button
            step        : 1
        }
        );
        </script>
        <span class='adminSpan'>End Date</span>
        <div class='date'><input class='adminInput date' type='text' value='' id='finish' name='finish' /><button id='finish_date'>...</button></div>
        <script type='text/javascript'>
        Calendar.setup(
        {
            inputField  : 'finish',          // ID of the input field
            ifFormat    : '%d/%m/%Y',     // the date format
            button      : 'finish_date',     // ID of the button
            step        : 1
        }
        );
        </script>
        <span class='adminSpan'>Event</span>
        <input class='adminInput' type='text' value='' id='event' name='event' />
        <span class='adminSpan details'>Details</span>
        <textarea class='adminTextarea' id ='details' name='details' rows='20' cols='60'></textarea>
        <span class='adminSpan'>Category</span>
        <select class='adminSelect' name='category'>
        $catList
        </select>
        <span class='adminSpan'>Price</span>
        <input class='adminInput' type='text' value='' id='price' name='price' />
        <span class='adminSpan'>Location</span>
        <input class='adminInput' type='text' value='' id='location' name='location' />
        <span class='adminSpan'>Link</span>
        <input class='adminInput' type='text' value='' id='link' name='link' />
        <span class='adminSpan'>Term</span>
        <div class='radioArray'>
        $term_options
        </div>
        <input type='submit' name='addProgItem' id='addProgItem' value='Submit' />
        </form>";
     
        return $addProgItemForm;
    }
     
     
     
     
    function editProgItemForm( $row )
    {
        global $fs, $terms;

        extract( $row );
        $start = date('d/m/Y', strtotime($start));
        $finish = date('d/m/Y', strtotime($finish));
        $list = $this->getCategories();
        while ( $cats = mysql_fetch_array( $list ) ) {
            $selected = ( $cats['category'] == $category ) ? 'selected=\'selected\'' : '';
            $catList .= "
            <option value='{$cats['category']}' $selected>{$cats['category']}</option>";
        }

        foreach ($terms as $t => $i) {
            $checked = ( $i == $term ) ? 'checked=\'checked\'' : '';
            $term_options .= "
            <input class='adminRadio' type='radio' name='term' value='$i' $checked/>
            <span class='adminSpanRadio'>$t</span>";
        }
        $editProgItemForm = "
        <h4 class='adminForm'>Edit Programme Item</h4>
        <form method='post' class='admin' id='editProgItem' action='{$fs['admin']}process.php?editProgItem&amp;id=$id'>
        <span class='adminSpan'>Start Date</span>
        <input type='hidden' id='id' name='id' value='" . $id . "' />
        <div class='date'><input class='adminInput date' type='text' value='$start' id='start' name='start' /><button id='start_date'>...</button></div>
        <script type='text/javascript'>
        Calendar.setup(
        {
            inputField  : 'start',        // ID of the input field
            ifFormat    : '%d/%m/%Y',     // the date format
            button      : 'start_date',   // ID of the button
            step        : 1
        }
        );
        </script>
        <span class='adminSpan'>End Date</span>
        <div class='date'><input class='adminInput date' type='text' value='$finish' id='finish' name='finish' /><button id='finish_date'>...</button></div>
        <script type='text/javascript'>
        Calendar.setup(
        {
            inputField  : 'finish',          // ID of the input field
            ifFormat    : '%d/%m/%Y',     // the date format
            button      : 'finish_date',     // ID of the button
            step        : 1
        }
        );
        </script>
        <span class='adminSpan'>Event</span>
        <input class='adminInput' type='text' value='$event' id='event' name='event' />
        <span class='adminSpan details'>Details</span>
        <textarea class='adminTextarea' id ='details' name='details' rows='20' cols='60'>$details</textarea>
        <span class='adminSpan'>Category</span>
        <select class='adminSelect' name='category'>
        $catList
        </select>
        <span class='adminSpan'>Price</span>
        <input class='adminInput' type='text' value='$price' id='price' name='price' />
        <span class='adminSpan'>Location</span>
        <input class='adminInput' type='text' value='$location' id='location' name='location' />
        <span class='adminSpan'>Link</span>
        <input class='adminInput' type='text' value='$link' id='link' name='link' />
        <span class='adminSpan'>Term</span>
        <div class='radioArray'>
        $term_options
        </div>
        <input type='submit' name='editProgItem' id='editProgItem' value='Submit' />
        </form>";
         
    
        return $editProgItemForm . $help;
    }
     
     
     
    function getCategories() 
    {
        global $tbl;
        $sql = "SELECT DISTINCT category
        FROM {$tbl['cal']}
        ORDER BY category ASC";
        $result = mysql_query( $sql );

        return $result;
    }
     
     
     
     
    function displayProgramme( $program = 'term' )
    {
        if ( isset( $_GET['t'] ) && isset( $_GET['y'] ) ) {
            $term = $_GET['t'];
            $year = $_GET['y'];
             
        } else {
            $term = $this->curTerm;
            $year = date( 'Y' );
        }

        $this->nextTerm = ( $term == 3 ) ? 1 : $term + 1;
        $this->lastTerm = ( $term == 1 ) ? 3 : $term - 1;

        $this->nextTermYear = ( $term == 3 ) ? $year + 1 : $year;
        $this->lastTermYear = ( $term == 1 ) ? $year - 1 : $year;

        if ( $term == 1 ) {
            $this->term = 'Spring';
        } elseif ( $term == 2 ) {
            $this->term = 'Summer';
        } elseif ( $term == 3 ) {
            $this->term = 'Winter';
        }

        $program = ( isset( $_GET['p'] ) ) ? $_GET['p'] : $program;
        $num = ( isset( $_GET['n'] ) ) ? $_GET['n'] : 0;

        $this->sql_limit = ($num > 0) ? 'LIMIT ' . $num : '';

        $programme = "<div class='center'><h2>Programme - {$this->term} {$year}"
        . "</h2></div>";
        $programme .= $this->displayProgrammeNavigation();

        switch( $program )
        {
            case 'term':
                $this->sql_where = "WHERE term = '{$term}'
                AND YEAR( start ) = '{$year}'";

                $programme .= $this->displayProgrammeTable();
                break;
                 
            case 'all':
                $this->sql_where = '';

                $programme .= $this->displayProgrammeTable();
                break;
                 
            case 'edit':
                $this->sql_where = 'WHERE finish >= CURDATE()';

                $programme = "<h3>Edit Programme</h3>";
                $programme .= $this->displayProgrammeTable( 1 );
                break;
                 
            case 'details':
                $id = ( isset( $_GET['id'] )) ? $_GET['id'] : '';
                $page = ( isset( $_GET['page'] )) ? $_GET['page'] : 'programme';
                $programme = $this->listProgrammeDetails( $id, $page );
                break;
                 
            default:
                $this->sql_where = "WHERE term = '{$term}'
                AND YEAR( start ) = '{$year}'";

                $programme .= $this->displayProgrammeTable();
                break;
        }

        return $programme;
    }
     
     
     
     
    function listProgrammeSummary()
    {
        global $fs_root;

        $this->sql_where = 'WHERE start >= CURDATE()';
        $this->sql_limit = 'LIMIT 5';

        $result = $this->getProgramme();

        $list = "
               <ul id='calendar'>";

        while ($row = mysql_fetch_assoc( $result )) {
            extract( $row );
            $list .= "
                  <li class='$id'>
                     <h4>";

            if ($start == $finish) {
                $from = date('d F',strtotime( $start ));
                $list .= $from;
            }
            //else print both the start and the finish date
            else {
                $from = date('d F',strtotime( $start ));
                $till = date('d F',strtotime( $finish ));
                $list .= "$from - $till";
            }
             
            $list .= "
            </h4>
            <ul>
            <li class='$id'><b>Event:</b> $event</li>
            <li class='$id'><b>Where:</b> $location</li>
            </ul>
            </li>";
        }

        $list .= '
               </ul>';

        return $list;
    }
     
     
     
     
    function listProgrammeDetails( $id = '', $page = 'programme' )
    {
        global $fs_root, $fs;
        $this->sql_where = ( $id != '' ) ? "WHERE id = $id" : '';
        $result = $this->getProgramme();

        $list = "";

        while ($row = mysql_fetch_assoc( $result )) {
            extract( $row );
            $list .= "
            <table class='progDetails'>
            <tr>
            <th colspan='2'>$event</th>
            </tr>
            <tr>
            <th class='title'>Date :</th>
            <td>";

            if ($start == $finish) {
                $from = date('d F',strtotime( $start ));
                $list .= $from;
            }
            //else print both the start and the finish date
            else {
                $from = date('d F',strtotime( $start ));
                $till = date('d F',strtotime( $finish ));
                $list .= "$from - $till";
            }

            $list .= "</td>
            </tr>
            <tr>
            <th class='title grey'>Details :</th>
            <td class='grey'>$details</td>
            </tr>
            <tr>
            <th class='title'>Price :</th>
            <td>$price</td>
            </tr>
            <tr>
            <th class='title grey'>Location :</th>
            <td class='grey'>$location</td>
            </tr>
            <tr>
            <th class='title'>Link :</th>
            <td><a href='$link' target='_blank' title='$event'>$link</a></td>
            </tr>
            </table>";
        }

        return $list;
    }
     
     
     
     
    function displayProgrammeNavigation()
    {
        global $fs_root;

        $nav = "
        <div class='prog_links'>
        <span class='left'>
        <a href='?t={$this->lastTerm}&amp;y={$this->lastTermYear}'>&lt;&lt; Last Term</a>
        </span>
        <span class='centre'>
        <a href=\"?p=all\">Whole Programme</a><br />
        <a href='{$fs_root}unitinfo/programme.php'>This Terms Programme</a><br />&nbsp;
        </span>
        <span class='right'>
        <a href='?t={$this->nextTerm}&amp;y={$this->nextTermYear}'>Next Term &gt;&gt;</a>
        </span>
        </div>";
        return $nav;
    }
     
     
     
     
    function displayProgrammeTable( $edit = 0 )
    {
        global $fs_root, $fs;

        $result = $this->getProgramme();
        $class = ( $edit > 0 ) ? 'admin progedit' : "prog' cellspacing='0'";
        $prog = "
        <h3>{$row['event']}</h3>
        <table class='{$class}'>
        <tr>
        <th>Date</th>
        <th>Activity</th>";
        $edit_col = "
                     <th>Edit</th>
                     <th>Delete</th>";
        $end_row = "
                  </tr>";
        $prog = ( $edit > 0 ) ? $prog . $edit_col . $end_row : $prog . $end_row;

        while ($row = mysql_fetch_array( $result )) {
            extract( $row );
             
            if ($start == $finish) {
                $from = date('d M',strtotime($start));
                $date = $from;
            } else {
                $from = date('d M',strtotime($start));
                $till = date('d M',strtotime($finish));
                $date = "$from - $till";
            }
             
            $prog .= "
            <tr>
            <td class='date'>$date</td>
            <td class='event'><a href='' onclick='return false;' id='$id'>$event</a></td>";
            $edit_col = "
            <td>
            <a href='?edit&amp;id=$id'>
            <img src='{$fs['img']}edit.png' alt='Edit' />
            </a>
            </td>
            <td>
            <a href='{$fs['admin']}process.php?deleteProgItem&amp;id=$id' onclick=\"return confirm('Are you sure you want to delete this item?')\">
            <img src='{$fs['img']}delete.png' alt='Delete' />
            </a>
            </td>";
            $prog = ( $edit > 0 ) ? $prog . $edit_col . $end_row : $prog . $end_row;
        }

        $prog .= "
               </table>";

        return $prog;
    }
    
    
    
    
    function outputICSFile() 
    {
        global $fs_root, $fs;

        $result = $this->getProgramme();
        
        $ics  = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//FreeSpirit ESU//Programme iCal Download//EN\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n"; 
        $ics .= "X-WR-TIMEZONE:Europe/London\r\n";
        
        while ($row = mysql_fetch_array( $result )) {
            extract( $row );
            
            $start = date('Ymd', strtotime($start));
            $end = date('Ymd', strtotime($finish));
            $event = addcslashes($event, ",\\;");
            $location = addcslashes($location, ",\\;");
            $description = addcslashes(trim(preg_replace('/\s+/', ' ', $details)), ",\\;");

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:{$id}-{$start}-{$event}\r\n";
            $ics .= "DTSTAMP:".date('Ymd').'T'.date('His')."\r\n";
            $ics .= "DTSTART;VALUE=DATE:{$start}\r\n"; 
            $ics .= "DTEND;VALUE=DATE:{$end}\r\n";
            $ics .= "LOCATION:{$location}\r\n";
            $ics .= "SUMMARY:{$event}\r\n";
            $ics .= "DESCRIPTION: {$description}\r\n";
            $ics .= "END:VEVENT\r\n";
        }
        
        $ics .= "END:VCALENDAR\r\n";
        
        return $ics;
    }



    public function outputCSV()
    {
        global $fs_root, $fs;
        
        $result = $this->getProgramme();

        $fh = @fopen( 'php://output', 'w' );

        $headings = array( 
        	'Start Date', 
        	'Start Time',
        	'End Date', 
        	'End Time', 
        	'Event', 
        	'Price', 
        	'Location', 
        	'Link',
        	'Description',
        	'Category',
        	'Post Date',
        	'Status'
        );

        fputcsv( $fh, $headings );

        while ($row = mysql_fetch_array( $result )) {
            extract( $row ); 
            
            $start_date = strtotime($start) + 68400;
            $start_time = date( 'H:i', $start_date );
            $end_date = strtotime($finish) + 75600;
            $end_time = date( 'H:i', $end_date ); 
            $event = str_replace( '"', "'",  preg_replace("/\s+/", " ", $event ) );
            $location = str_replace( '"', "'",  preg_replace("/\s+/", " ", $location ) );
            $description = str_replace( '"', "'", preg_replace("/\s+/", " ", preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $details ) ) );
            $cat = strtolower( str_replace( " ", "_", $category ) );
            $publish = date( "Y-m-d H:i:s", $start_date );

            $csv = array(
                $start_date,
                $start_time,
                $end_date,
                $end_time,
                "$event",
                "$price",
                "$location",
                "$link",
                "$description",
                "$cat",
                "$publish",
                'Published'
            );
            fputcsv( $fh, $csv );
        }

        fclose( $fh );

        exit;
    }
}
