<?php session_start();
/*
*  Filename:      links.php
*  Author:        Richard Perry (richard@perrymail.me.uk)
*  Description:   A script to get the links from the database and
*                 display them on screen
*  To do:         
*                 
*/

  //declare variables used by the header to determine the page specific items
  $title = 'Links';                    //title to show in window head
  $page = 'links';
  $pclass = 'lnk';                        //set page class for colour options
  
  include 'library/common.php';
  include 'template/header.php';

  $mysql = new db; //create new db object
  $mysql->open();  //run the open() function which connects to the database
    
  echo "<div class='columns'>\n";    
  links('Network Web Sites', 'Network');  
  echo "</div>\n\n<div class='columns'>\n";
  links('County &amp; District Sites', 'District');
  links('National Sites', 'National');
  links('Events', 'Event');
  echo "</div>\n";
    
  $mysql->close(); //close the database connection
  
  include 'template/footer.php';
?>
