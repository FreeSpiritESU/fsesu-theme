<?php
/* SVN File: $Id$ */
   
   if( !defined('IN_FSW') )
   {
     die();
   }
   
   function connectDB()
   {
      global $db;
      $conn = mysql_pconnect( $db['host'], $db['user'], $db['password'] );
      mysql_select_db( $db['name'], $conn);
   }
   
   
   
   
   function closeDB()
   {
      global $db;
      $conn = mysql_connect( $db['host'], $db['user'], $db['password'] );
      mysql_close( $conn );
   }
   
   
   
   
   function displayHeader()
   {
        global $fs_root, $page_title;
        
        $header = "
      <div id='header'>
        <img src='{$fs_root}images/fslogo.png' title='FreeSpirit ESU' alt='FreeSpirit ESU' style='float: left' />
        <div style='float: right; width: 143px; height: 180px;'>&nbsp</div>
        <h1 style=''>FreeSpirit ESU</h1><br />
        <h4 style='color: red'>{$page_title}</h4>
      </div>
      ";
      return $header;
   }
   
   
   
   function downloads($cat, $class, $title = 0)
   {
      global $tbl, $fs_root;
      $sql = "SELECT *
              FROM {$tbl['dl']}
              WHERE cat LIKE '%$cat%'";
      $result = mysql_query( $sql );
      
      $dl = "
            <div class='$class'>
               ";
      $dl .= ($title == 1) ? '<h3>Downloads</h3>' : '';
      while ($row = mysql_fetch_assoc( $result ))
      {
         $dl .= "
               <a href='{$fs_root}files/{$row['link']}' title='
               {$row['title']}'>
               <img src='{$fs_root}images/{$row['doctype']}.jpg' />
               &nbsp;&nbsp;{$row['title']}
               </a><br />";
      }
      $dl .= "
            </div>
            ";
      
      return $dl;
   }
   
   
   
	function homepic()
	{
		global $fs_root, $tbl, $gall_link;
      
		// get the details of pics from the db
		$sql = 'SELECT *
		        FROM ' . $tbl['pics'];
		$result = mysql_query ( $sql );
		$num = mysql_num_rows( $result );
		
		// chose a random number between 0 and the number of pics in the db
		$id = rand(0, $num - 1);
		
		// assign the title, and image source link to the title and src variables
		// based on the random id selected above
		$title = mysql_result( $result, $id, 'title' );
		$src = mysql_result( $result, $id, 'link' );
		
		// remove the image filename from the src to create a link to the folder
		// holding the image
		$link = preg_replace( '/(.*?)\/(.*?)(?i:\.jpg|\.gif|\.png)/', '\\1/', $src );
		
		// display the image selected
		$pic = '
            <a href=\'' . $gall_link . $link . '\' target=\'_blank\'>
                  <img src=\'' . $gall_link . $src . '\' style=\'width: 400px; border: 0;\' alt=\'' . $title . '\'>
               </a>
               <h4>' . $title . '</h4>';
      
		return $pic;
	}
	
	
	
	function breadcrumb( $page )
	{
		$parts = explode("/", dirname($_SERVER['REQUEST_URI']));  
		$breadcrumb = "<a href='/'>Home</a> &gt;&gt; ";
		foreach ($parts as $key => $dir) {
			switch ($dir) {
			    case "unitinfo":    $label = "Unit Info"; break;
			    case "downloads":   $label = "Downloads"; break;
			    case "campdiaries": $label = "Camp Diaries"; break;
			    case "members":     $label = "Members Area"; break;
			    case "fsa":         $label = "Site Administration Panel"; break;
			    default:            $label = ucfirst($dir); break;   
		    }
		    $url = '';
		    for ($i = 1; $i <= $key; $i++) { 
			    $url .= $parts[$i] . '/'; 
		    }
		    if ($dir != '') {
			    $breadcrumb .= "<a href='$url'>$label</a> &gt;&gt; ";
			}
		}
		$breadcrumb .= $page;
		
		return $breadcrumb;
	}

	
	
	
    function links($head, $set)
    {
        global $tbl;
        
        // set the header for the list of links
        $links = "
            <div class='links'>
                <h3>$head</h3>
                <ul style='list-style: none'>";
        
        // find the links of the chosen type for display
        $sql = "SELECT * 
                FROM {$tbl['links']} 
                WHERE category = '$set' 
                ORDER BY title";
        $result = mysql_query($sql) or die('Error locating links<br />' . mysql_error());
          
        while( $row = mysql_fetch_array( $result ) ) {
            $links .= "
                    <li><a target='_blank' href='{$row['link']}'>{$row['title']}</a></li>";
        }
        
        $links .= "
                </ul>
            </div>";

        return $links;
    } 
    
    
    
    
    function pressCuttings()
    {
        global $tbl, $fs_root, $fs;
        $sql = "SELECT *
                FROM {$tbl['press']}
                ORDER BY date DESC";
        $result = mysql_query( $sql );
        
        $press = "
            <div class='center'>
               ";
        $press .= '<h2>Press Cuttings</h2>
                   <p>This page houses various press cuttings, awards and certificates that we have gathered over the years.</p>';
        while ($row = mysql_fetch_assoc( $result )) {
            $press .= "
                <div style='float: left; width: 335px; height: 300px'>
                <a href='{$fs['img']}presscuttings/{$row['img']}' title='
                {$row['title']}' target='_blank'>
                <img src='{$fs['img']}presscuttings/{$row['img']}' style='max-height: 250px; max-width: 250px' />
                </a>
                <p>{$row['title']}</p>
                </div>";
        }
        $press .= "
            </div>
            ";
        
        return $press;
    }



    function intOpps()
    {
        global $tbl, $fs_root, $fs;
        $sql = "SELECT *
                FROM {$tbl['intopp']}
                WHERE `start` > CURDATE() 
                ORDER BY start ASC";
        $result = mysql_query( $sql );

        $intopp = '<div class="center">
                       <h2>International Opportunities - What\'s Happening
                       Worldwide?</h2>
                   </div>
                   <p>A selection of International Opportunities organised through
                   Scouting that are available for you. If you are intereseted in
                   any of them, get in touch with the organisers. We will help you
                   with whatever you need.</p>
                   <p>For information about many many more international opportunities, 
                   please visit the International Page at Scouts.org.uk 
                   <a href="http://scouts.org.uk/international" title="International">
                   http://scouts.org.uk/international</a>.</p>';
        while ($row = mysql_fetch_assoc( $result )) {
            $img = (isset($row['img'])) ? $row['img'] : '/images/noimage.jpg';
            $date = (isset($row['start'])) ? date ('d M',strtotime($row['start'])) . ' - '
                     . date ('d M Y',strtotime($row['finish'])) : "";
            $intopp .= "
                <div style='border-bottom: 1px solid #aeaeae; min-height: 165px;'>
                <a href='{$row['link']}' title='{$row['title']}' target='_blank'>
                <img src='{$img}' style='border: 1px solid #aeaeae;
                float: left; height: 150px; max-width: 150px; margin: 0 10px' />
                </a>
                <h4>What : </h4><p>{$row['title']}</p>
                <h4>Where : </h4><p>{$row['where']}</p>
                <h4>When : </h4><p>$date</p>
                <h4>About : </h4><p>{$row['description']}</p>
                </div>";
        }

        return $intopp;
    }