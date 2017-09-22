<?php
/*
*  Filename:      functions.php
*  Author:        Richard Perry (richard@perrymail.me.uk)
*  Description:   This file holds the main functions that are used throughout 
*                 the website.
*  To do:         
*                 
*/

  //Age calculator - downloaded script from website, amended slightly to suit
  //Is there a better way???
  function dateDiff($dformat, $endDate, $beginDate) 
  {
    //convert dob from MySQL date format to format compatible with gregoriantojd()
    $beginDate = date ("m/d/Y", strtotime($beginDate)); 
    
    //break dates down into their constituent parts within an array
    $date_parts1 = explode ($dformat, $beginDate); 
    $date_parts2 = explode ($dformat, $endDate);
    
    //convert dates from gregorian to julian days to make the sum simple numerical mathematics
    $start_date = gregoriantojd ($date_parts1[0], $date_parts1[1], $date_parts1[2]);
    $end_date = gregoriantojd ($date_parts2[0], $date_parts2[1], $date_parts2[2]);
    
    //return the difference between the dob and todays date
    return $end_date - $start_date;
  }
  
  //function for getting the latest news from the database and printing it on screen
  function news()
  {
    $mysql = new db;
    $mysql->open();
    
    $strout = "
      <div class='news_body'>
        <h1>News</h1>";
        
    if (!isset ($_GET['id']))
    {
      //select all news items and sort in reverse order by the id
      $result = mysql_query ( 'SELECT * FROM news ORDER BY ID DESC' );
      $num = mysql_num_rows ( $result );
       
      $mysql->close();
      
      //Only 5 news items should be shown on the home page unless $_GET['news']
      //is set (when all news is displayed), therefore set the integer to 5
      if (!isset ( $_GET['news']) )
      {
        if ( $num < 5)
        {
          $to = $num;
        }
        else
        {
          $to = 5;
        }
      }
      else
      {
        $to = $num; //if $_GET['news'] is set, set the integer to the number 
                    //of rows found
      }
      $id = mysql_result ( $result, $i, 'id' );
      $title = mysql_result ( $result, $i, 'title' );
      $entry = mysql_result ( $result, $i, 'entry' );
      $date = mysql_result ( $result, $i, 'date' );
      
      $date = date ('l d F Y',strtotime($date));
            
      $i = 0;
      
      // output the most recent news item in full
      $strout .= "
          <div>
            <h2>" . $title . "</h2>
            <blockquote>" . $date . "</blockquote>
            <p>" . $entry . "</p>
          </div>";
          
      $i++;  // increase the value of $i by 1 so that the first news item is not displayed again
      
      while ($i < $to) 
      { 
        $id = mysql_result ( $result, $i, 'id' );
        $title = mysql_result ( $result, $i, 'title' );
        $entry = mysql_result ( $result, $i, 'entry' );
        $date = mysql_result ( $result, $i, 'date' );
        
        $date = date ('l d F Y',strtotime($date));
        
        // display the first 250 characters of each of the other news stories, and include a link to show the whole story
        $strout .= "
            <div class='news'>
              <h2>" . $title . "</h2>
              <blockquote>" . $date . "</blockquote>
              <p>" . substr(strip_tags($entry), 0, 250) . " ...</p>
              <p align='right'><a href='?id=" . $id . "' class='blue'>Click here to read more</a></p>
            </div>";
            
        $i++;
      }
      
      //if there are more than 5 news items found, display a link to show all articles
      if (!isset ($_GET['news']))
      {
        if ($num > 5)
        {
          $strout .= "
              <small><a href='?news=1'>Click here for previous articles</a></small>";
        }
      }
      $strout .= "
        </div>";
    }
    else
    {  
      $id = $_GET['id']; // get the news story id from the address
      
      //select the relevant news item and display
      $result=mysql_query("SELECT * FROM news WHERE id = '$id'");
       
      $mysql->close();
      
      $title = mysql_result ( $result, $i, 'title' );
      $entry = mysql_result ( $result, $i, 'entry' );
      $date = mysql_result ( $result, $i, 'date_entered' );
          
      $strout .= "
          <div>
            <h2>" . $title . "</h2>
            <blockquote>" . $date . "</blockquote>
            <p>" . $entry . "</p>
            <p align='right'><a href='./' class='blue'>back</a></p>
          </div>
        </div>";
    }
    
    return $strout;
  }
  
  //function to read the events from the 'calendar' table for the homepage
  function calendar()
  {
    $mysql = new db;
    $mysql->open();
    
    $strout = "
        <div id='calendar'>
          <ul>";
    
    //look only for those events that are happening in the future, or have finished within the last 4 days
    $result = mysql_query ('SELECT * 
    												FROM calendar 
    												WHERE finish >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    												  AND start <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) 
    												ORDER BY start');
    
    $mysql->close();
  
    while (list ($id, $start, $finish, $event, $details, $link, $location, $price, $close) = mysql_fetch_array ($result))
    {
      $strout .= "
            <li>
              <h3><a href='events.php?id=".$id."'>" . $event . "</a></h3>
              <ul>
                <li><b>Where:</b> " . $location . "</li>
                <li><b>When:</b>";
      //if the start and finish date are the same, only print the start date
      if ($start == $finish)
      {
        $from = date('d M y',strtotime($start));
          $strout .= $from;
      }
      //else print both the start and the finish date
      else 
      {
        $from = date('d M y',strtotime($start));
        $till = date('d M y',strtotime($finish));
        $strout .= "$from - $till";
      }
      //print the name of the event, and create a link to the event website
      
      $strout .= "</li>
                <li><b>Cost:</b> " . $price . "</li>
              </ul>
            </li>";
    }
    $strout .= "
          </ul>
        </div>
        ";
    
    return $strout;
  }
  
  // links() a function to find and display the various links based on the chosen set, and column
  function links($head, $set)
  {
    // set the header for the list of links
    $strout = "<div class='linkhead'>\n";
    $strout .= "  <span>$head</span>\n";
    $strout .= "</div>\n";
    
    // find the links of the chosen type for display
    $query = "SELECT address, title FROM links WHERE type = '$set' ORDER BY title";
    $result = mysql_query($query) or die('Error locating links<br />'.mysql_error());
      
    while(list($address, $title) = mysql_fetch_array($result))
    {
      $strout .= "<div class='link_row'>\n<a target='_blank' href='".$address."'>";
      $strout .= $title."</a>\n</div>\n";
    }
    print $strout;
  }    

?>
