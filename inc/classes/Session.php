<?php
/*
*  Filename:      class.session.php
*  Author:        Richard Perry (richard@perrymail.me.uk)
*  Description:   
*  Functions:     session()
                  checkLogin()
                  checkUsername()
                  getUserdata()
                  setActiveUser()
                  setActiveGuest()
                  getActiveUsers()
                  getActiveGuest()
                  clearInactive()
                  removeUserOnLogout()
                  numActiveUsers()
                  
*  Usage:      1. 
*
*/ 
if( !defined('IN_FSW') )
{
  die();
}

class Session
{
   
   // variables
   
   public $username;            // username given on sign-up
   public $time;                // time user was last active (page loaded)
   public $logged_in;           // true if user is logged in, false otherwise
   public $sess_id;             // random value generated on current login
   public $userdata = array();  // the array holding all user info
   public $activeUsers;         // the number of active users
   public $activeGuests;        // the number of active guests
   public $referrer;            // the last page visited
   
   
   
   
   //functions
   
  /**
   *  __construct() - runs on instantiation of the session class. Designed 
   *  to ensure that there is a session running and if not, starts one. Then 
   *  checks the status of the user, logged in member, or simply a visiting 
   *  guest. Adds the user to the relevant active user/guest table for 
   *  monitoring who is online and finally clears inactive users.
   */
   function __construct()
   {
      global $fs_root;
      
      // start the php session
      session_start();
      
      // set the time variable so the system knows when the session becomes inactive
      $this->time = time();
      $ip = getenv('REMOTE_ADDR');
      
      //check to see if the user is logged in, or just a guest
      $this->logged_in = $this->checkLogin();
      
      // if the user is a guest, set the username to guest
      if (!$this->logged_in) {
         $this->username = $_SESSION['username'] = 'Guest';
         $this->userdata['userlevel'] = 0;
      }
   }
   
   
   
   function checkLogin()
   {
      // start by checking if a username and session id have been remembered
      if(isset($_COOKIE['username']) && isset($_COOKIE['sess_id'])) {
         $this->username = $_SESSION['username'] = $_COOKIE['username'];
         $this->sess_id  = $_SESSION['sess_id']  = $_COOKIE['sess_id'];
      }

      // then check that the username and session id have been set and the username is not guest
      if(isset($_SESSION['username']) && isset($_SESSION['sess_id']) && $_SESSION['username'] != 'Guest') {
         // then check that the username exists and the sess_id is valid
         if(!$this->checkUsername($_SESSION['username'], $_SESSION['sess_id'])) {
            // if the details are invalid, unset the variables
            unset($_SESSION['username']);
            unset($_SESSION['sess_id']);
            return false;
         }

         // otherwise the user is valid, so set the variable
         $this->userdata  = $this->getUserdata($_SESSION['username']);
         $this->username  = $this->userdata['username'];
         $this->sess_id   = $this->userdata['sess_id'];
         return true;
      }
      /* User not logged in */
      else {
         return false;
      }
   }
   
   
   
   function checkUsername( $user, $sess_id )
   {
      global $tbl;
      
      // select the sess_id stored in the database against the username and confirm it matches
      $sql = "SELECT sess_id
              FROM {$tbl['users']}
              WHERE username = '{$user}'
              LIMIT 1";
      $result = mysql_query( $sql );
      $row = mysql_fetch_array( $result );
      
      if ($row['sess_id'] != $sess_id) {
         return false;
      }
      return true;
   }
   
   
   
   function getUserdata( $username )
   {
      global $tbl;
      
      // select all details from the database for the user requested
      $sql = "SELECT * 
              FROM {$tbl['users']} 
              WHERE username = '{$username}' 
              LIMIT 1";
      $result = mysql_query( $sql );
      
      // if the query fails, return false
      if(!$result || (mysql_numrows($result) < 1)) {
         return false;
      }
      
      $this->userdata = mysql_fetch_assoc( $result );
      return $this->userdata;
   }
}
?>