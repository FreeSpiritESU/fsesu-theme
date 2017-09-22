<?php
define('IN_FSW', true);

require_once( './config.inc.php' );
require_once( 'Class/User.php' );

$who = new User;

/**
 * Set the query depending on what category is chosen to be displayed
 */
$category = $_GET['c'];
switch ( $category ) {
    case 'leaders':
        $who->sql_where = "WHERE category = 'leader'";
        $who->sql_order = 'uid';
        $title = 'Leaders';
        break;

    case 'members':
        $who->sql_where = "WHERE category = 'member'";
        $who->sql_order = 'surname';
        $title = 'Members';
        break;

    case 'committee':
        $who->sql_where = "WHERE category = 'committee'";
        $who->sql_order = 'surname';
        $title = 'Unit Committee';
        break;

    default:
        $who->sql_where = "WHERE category = 'leader'";
        $who->sql_order = 'uid';
        $title = 'Leaders';
        break;
}

$page = "Who's Who - " . $title;

$result = $who->getUsers();

$body = "<div class='center'><h2>Who's Who - $title</h2></div>";
while ($row = mysql_fetch_assoc( $result ))
{
    // members don't have positions, so don't set the position item
    if ( $category != 'members' ) {
        $position = $row['position'] . ' - ';

        // committee also kids so don't show their email address
        if ( $category != 'committee' ) {
            $contact = "
            <div>Contact -
            <a href='mailto:{$row['email']}'>{$row['email']}</a>
            </div>";
        }
    }
	
	$pic = "images/profiles/{$row['username']}.jpg";
	$pic = ( file_exists( $pic )) 
		? "/images/profiles/{$row['username']}.jpg" 
		: "/images/profiles/pic.jpg";

    $body .= "
    <div class='who'>
    <img src='{$pic}' alt='{$row['forename']}' class='pic' />
    <h3>{$position}{$row['forename']}</h3>
    <div>{$row['sdesc']}</div>
    {$contact}
    </div>";
}

$tpl =  $path['templates'] . 'default.tpl';
include_once( 'template.php' );
print $html;
