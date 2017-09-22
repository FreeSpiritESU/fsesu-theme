<?php
/*
*  Filename:      class_rss.php
*  Author:        Richard Perry (richard@perrymail.me.uk)
*  Description:   A class for aggregating an RSS feed
*  Functions:     getFeed()
*                 formatFeed()
*  Usage:      1. include the class      include 'class_rss.php';
*              2. declare the class      $rss = new rss;
*              3. set the feed address   $rss->rss_url = 'http://www.rss.com/rss.xml';
*              4. get the feed           $rss->getFeed($num[, $feed_type]); //
*                     where $num is the number of items to show
*                       and $feed_type allows for using the Network Events feed
*                           if feed_type is set to netevents, the description will
*                           not be used, but instead the date is stripped out of
*                           the title.
*              5. print the results      print $rss->feed;
*
*/ 

class Rss
{
   // full url of the feed to be used
   var $rss_url;

   // for collating the feed output
   var $feed;

   // getFeed() draws the feed from the source and adds the results to the $feed variable
   function getFeed($num, $html = 'feed')
   {
      // open the feed and assign the contents to the $rss_feed variable for handling later
      $rss_feed = file_get_contents( $this->rss_url );
    
      // remove <image> tag as it sometimes contains <title> and <link> tags 
      $rss_feed = preg_replace('#<image>(.*?)</image>#', '', $rss_feed, 1 );

      // find the titles, links and descriptions of all items in the feed
      preg_match_all('#<title>(.*?)</title>#', $rss_feed, $title, PREG_SET_ORDER); 
      preg_match_all('#<link>(.*?)</link>#', $rss_feed, $link, PREG_SET_ORDER);
      preg_match_all('#<description>(.*?)</description>#', $rss_feed, $description, PREG_SET_ORDER); 

      // check that there are actually items within the feed
      if (count($title) <= 1)
      {
         $this->feed = 'No items at present';
      }
      else
      {
         // add the feed title and link to the out put variable
         $this->feed = "
         <div class='rss'>";
         
         // add each feed item to the feed output
         for ( $i = 1; $i <= $num; $i++ )
         {
            // format the feed in accordance with where the feed came from
            $this->feed .= $this->formatFeed($title[$i][1],$description[$i][1],$link[$i][1],$html);
         }
         
         // close the feed div
         $this->feed .= "
         </div>";
      }
      return $this->feed;
   }
   
   // format the feed data found into browser readable html
   function formatFeed($title, $description, $link, $html = 'feed')
   {
      // check to see if the feed is from network events or not
      if ($html == 'feed')
      {
         // if the feed is not network events, then display the title and the description
         $htmlout .= "
      <h3><a href='{$link}' target='_blank' title='{$title}'>{$title}</a></h3>
      <p>{$description}</p>";
      }
      elseif ($html == 'netevents')
      {
         // if the feed is network events, split the title to separate the event title and dates
         list($title, $date) = explode(' -- ', $title);
         
         // capitalise the first letter of each word in the title
			$title = ucwords(strtolower($title));
         
         // remove the times from the date string
         $pattern = array('/\s\@\s\d{2}:\d{2}/','/\s(?i:to)\s\d{2}:\d{2}/');
         $replace = array('','');
         $date = preg_replace($pattern, $replace, $date);
         
         // output the title followed by the event date
         $htmlout .= "
      <h3><a href='{$link}' target='_blank' title='{$title}'>{$title}</a></h3>
      <p>{$date}</p>";
      }
      return $htmlout;
   }
}

?> 