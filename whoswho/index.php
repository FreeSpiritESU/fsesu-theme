<?php
    define('IN_FSW', true);
    $fs_root = '../';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/User.php' );
    
    $who = new User;
    
    // set the query depending on what category is chosen to be displayed
    $category = $_GET['c'];
    switch ( $category ) {
        case 'leaders':
            $who->sql_where = "WHERE category = 'leader'";
            $who->sql_order = 'uid';
            $title = $class = "Who's Who - Leaders";
            break;
        
        case 'members':
            $who->sql_where = "WHERE category = 'member'";
            $who->sql_order = 'dob';
            $title = $class = "Who's Who - Members";
            break;
        
        case 'committee':
            $who->sql_where = "WHERE category = 'committee'";
            $who->sql_order = 'position';
            $title = $class = "Who's Who - Unit Committee";
            break;
        
        default:
            $who->sql_where = "WHERE category = 'leader'";
            $who->sql_order = 'uid';
            $title = $class = "Who's Who";
            break;
    }
    
    $page = $title;
    
    $result = $who->getUsers();
    
    $body = "<div class='center'><h2>$title</h2></div>";
    while ($row = mysql_fetch_assoc( $result ))
    {
        // include a nickname if known
        if ( $row['nickname'] != '' ) {
            $nick = "({$row['nickname']})";
        } else {
            $nick = '';
        }
        
        // members don't have positions, so don't set the position item
        if ( $category != 'members' ) {
            $position = ($row['position']) 
				? $row['position'] . ' - '
				: '';
            
            // committee also kids so don't show their email address
            if ( ( $category != 'committee' )  &&  ( $row['email'] != '' ) ) {
                $contact = "
            <div>Contact - 
               <a href='mailto:{$row['email']}'>{$row['email']}</a>
            </div>";
            } else { $contact = ''; }
        }
		
    $class = strtolower($class); 
		$pic = "../images/profiles/{$row['img']}.jpg";
		$pic = ( file_exists( $pic )) 
			? "/images/profiles/{$row['img']}.jpg" 
			: "/images/profiles/pic.jpg";
        
        $body .= "
         <div class='who {$class}'>
            <img src='{$pic}' alt='{$row['forename']}' class='pic' />
            <h3>{$position}{$row['forename']} {$nick}</h3>
            <div>{$row['sdesc']}</div>
            {$contact}
         </div>";
    }
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>