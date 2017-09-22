<?php

$year = (isset( $_GET['y'] )) ? $_GET['y'] : date('Y');

$month['1']     = 'Jan';
$month['2']     = 'Feb';
$month['3']     = 'Mar';
$month['4']     = 'Apr';
$month['5']     = 'May';
$month['6']     = 'Jun';
$month['7']     = 'Jul';
$month['8']     = 'Aug';
$month['9']     = 'Sep';
$month['10']    = 'Oct';
$month['11']    = 'Nov';
$month['12']    = 'Dec';


/**
 * Find all events relating to the date supplied and add to a string for
 * handling by the display script
 *
 * @param int $y
 * @param int $m
 * @param int $d
 * @return string
 */
function fsEvents( $y, $m, $d ) 
{
    global $tbl;
    
    $date = "$y-$m-$d";
    
    $sql = 'SELECT *
            FROM ' . $tbl['cal'] . ' 
            WHERE start <= \'' . $date . '\' ' .
                'AND finish >= \'' . $date . '\'';
    $result = mysql_query( $sql );
    
    $row = mysql_fetch_array( $result );
    
    if ( date( 'N', mktime( 0, 0, 0, $m, $d, $y )) > 5 ) {
        if ( !$row['category'] ) {
            $events = "<td class='weekend'>" .
            $d .
            "</td>";
        } else {
            $events = "<td class='weekend event " .
                substr( $row['category'], 0, 3) .
                "'><a href='' onclick='return false;' id='" . 
                $row['id'] . 
                "' title='" . 
                $row['event'] .
                "' >" .
                $d .
                "</a></td>";
        }
    } else {
        if ( !$row['category'] ) {
            $events = "<td>" .
                $d .
                "</td>";
        } else {
            $events = "<td class='event " .
                substr( $row['category'], 0, 3) .
                "'><a href='' onclick='return false;' id='" . 
                $row['id'] . 
                "' title='" . 
                $row['event'] .
                "' >" .
                $d .
                "</a></td>";
        }
    }
    return $events;
    
}


function planner( $details = '' )
{
    global $month, $year;
    
    $next = $year + 1;
    $prev = $year - 1;
    
    $calendar = "
<h3>Year Planner - $year</h3>
<table id='planner' cellspacing='0'>";

    foreach ( $month as $nr => $name ) {
        if ( $nr &1 ) {
            $calendar .= "
    <tr>";
        } else {
            $calendar .= "
    <tr class='even'>";
        }
        $calendar .= "
        <th class='month'>$name</th>";
    
        $days_in_month = cal_days_in_month( CAL_GREGORIAN, $nr, $year );
        $first_day = date('w', mktime( 0, 0, 0, $nr, 1, $year ));
        $first_day = ( $first_day == 0 ) ? 7 : $first_day;
        $days = $first_day + $days_in_month;
        $counter = 1;
        
        for ( $i = 1; $i < 38; $i++ ) {
            $counter++;
            $date[$i] = $counter;
            $date[$i] -= $first_day;
            if ( $date[$i] < 1 || $date[$i] > $days_in_month ) {
                $calendar .= '<td>&nbsp;</td>';
            } else {
                $calendar .= fsEvents( $year, $nr, $date[$i] );
            }
        }
        $calendar .= " 
    </tr>";
    }
    
    $calendar .= "
</table>

<div class='years'>";

if ($year != '2008') {
    $calendar .= "
    <a href='planner.php?y=$prev' title='Previous'>&lt;&lt; Prev</a>  |  
    <a href='planner.php?y=$next' title='Previous'>Next &gt;&gt;</a>";
} else {
    $calendar .= " 
    <a href='planner.php?y=$next' title='Previous'>Next &gt;&gt;</a>";
}

$calendar .= "
</div>

<ul class='eventType'>
    <li class='Cam'>Camp</li>
    <li class='Hik'>Hike</li>
    <li class='Mon'>Monday Night</li>
    <li class='Out'>Outdoor Activity</li>
    <li class='Int'>International Activity</li>
    <li class='Jam'>Jamboree</li>
    <li class='Non'>Non-Explorer Activity</li>
    <li class='Oth'>Other Activity</li>
</ul>


<div id='eventInfo'>
    {$details}
</div>";
    
    return $calendar;
}
