<?php
/* SVN File: $Id$ */

if( !defined('IN_FSW') )
{
  die();
}

/**
 * $db - this array holds all the information for connecting to
 * the database allowing the dynamic content to be viewed. Set
 * the user, password and name to the username, password and
 * database name relevant to your MySQL database.
 */
$db['user']           = 'cl50-fsesu';
$db['password']       = 'kEqs^rc9E';
$db['host']           = 'localhost';
$db['name']           = 'cl50-fsesu';

/**
 * $tbl - this array holds the names of each of the tables used
 * to store the information needed for the various site systems
 * to work.
 */
$tbl['news']          = 'fs_news';
$tbl['nav']           = 'fs_menu';
$tbl['links']         = 'fs_links';
$tbl['nav_del']       = 'fs_menu_deleted';
$tbl['users']         = 'fs_users';
$tbl['active_users']  = 'fs_users_active';
$tbl['active_guests'] = 'fs_guests_active';
$tbl['scouting']      = 'fs_users_scouting';
$tbl['cal']           = 'fs_calendar';
$tbl['dl']            = 'fs_downloads';
$tbl['pics']          = 'fs_homepic';
$tbl['press']         = 'fs_press';
$tbl['intopp']        = 'fs_intopp';

/** 
 * $fs - an array for holding the folder information of the main 
 * folders used by the site
 */
$fs['who']           = $fs_root . 'whoswho/';
$fs['members']       = $fs_root . 'members/';
$fs['info']          = $fs_root . 'unitinfo/';
$fs['parents']       = $fs_root . 'parents/';
$fs['camps']         = $fs_root . 'campdiaries/';
$fs['admin']         = $fs_root . 'fsa/';
$fs['files']         = $fs_root . 'files/';
$fs['js']            = $fs_root . 'js/';
$fs['img']           = $fs_root . 'images/';
$fs['css']           = $fs_root . 'css/';
 
$fs['admin_news']    = $fs['admin'] . 'news.php';
$fs['admin_menu']    = $fs['admin'] . 'menu.php';
$fs['admin_content'] = $fs['admin'] . 'content.php';
$fs['admin_prog']    = $fs['admin'] . 'programme.php';
$fs['admin_users']   = $fs['admin'] . 'members.php';
$fs['admin_dl']      = $fs['admin'] . 'downloads.php';
$fs['admin_diaries'] = $fs['admin'] . 'diaries.php';
$fs['admin_links']   = $fs['admin'] . 'links.php';


$terms['Spring'] = '1';
$terms['Summer'] = '2';
$terms['Autumn'] = '3';
/**
 * $timeout - maximum amount of time (in minutes) after the users 
 * last page fresh that a user and guest are still considered
 * active visitors.
 */
$timeout              = 30;

/**
 * $cookie - holds the information for setting the cookie for 
 * remembering a users session. The expiration time is set at
 * 60 * 60 * 24 *60 (60 days) by default, and the path is set
 * to '/' so that it is available to the whole domain
 */
$cookie['expire']     = 60 * 60 * 24 * 60;
$cookie['path']       = '/';

/**
 * $gallery - for easily inserting a link to the gallery page
 */
$gall_link            = "{$fs['members']}fsg.php";
$gallery              = "<a href='{$gall_link}' title='FreeSpirit Gallery'>Gallery</a>";
$downloads            = "<a href='".$fs['info']."downloads/' title='Downloads'>downloads</a>";

$separator            = "<img src='{$fs_root}images/canrow.gif' alt='separator' class='separator' />";

$feed['fsphotos']  = 'http://s95.photobucket.com/albums/l155/honestsi/account.rss';
