<?php
/**
 *  A class for managing user logins, adding, updating and deleting users etc.
 *
 *  @author Richard Perry (richard@perrymail.me.uk)
 *  @version 1.0
 *  @package FreeSpirit
 *
 */
/**
 * Ensures the script is not run independantly of another page
 */
if( !defined('IN_FSW') ) {
    die();
}

class User
{
     
    // variables
     
    public $sql_where;
    public $sql_order;
    public $login_text;
     
    //functions

    /**
     *  Gets all the users and their details from the database
     *
     *  @return mixed
     */
    public function getUsers()
    {
        global $tbl;

        /**
         *  Checks if $sql_order has been set, otherwise use the default value
         */
        if (!$this->sql_order) {
            $this->sql_order = 'uid';
        }

        $sql = "SELECT *
        FROM {$tbl['users']} {$this->sql_where}
        ORDER BY {$this->sql_order} ASC";
        $result = mysql_query( $sql );

        if (!$result) {
            return "Error connecting to the database. Please contact administrator";
        }

        return $result;
    }
     
     
     
     
    /**
     *  Checks submitted login details and logs the user in if they are correct
     *
     *  This function first checks that the username and password combination
     *  exist, if not, then it returns a failed statement to the user. It then
     *  collates the user details into an array using the getUserdata function,
     *  sets up the new session and, if requested, adds a cookie to the users
     *  computer so that they are remembered. It will also add a file to the
     *  forum folder structure allowing the user to view the FreeSpirit forum
     *
     *  @param string  $user    Username submitted from the form
     *  @param string  $pass    Password submitted from the form
     *  @param boolean $rem     Remember the user or not?
     *  @global string $fs_root Root path
     *  @global array  $tbl     An array of the database tables used by FreeSpirit
     *  @global array  $cookie  Expiration time and cookie path
     *  @global array  $session Access to session class
     *  @return mixed
     */
    function login($user, $pass, $rem)
    {
        global $fs_root, $tbl, $cookie, $session;

        /**
         *  Clean up the submitted username and password to ensure no sql
         *  code can be injected into the query, then md5 encrypt the
         *  password so that it can easily be compared to the password
         *  stored in the database
         */
        $user = addslashes(trim($user));
        $pass = md5(addslashes(trim($pass)));

        $sql = "SELECT *
        FROM {$tbl['users']}
        WHERE username = '{$user}'
        AND password = '{$pass}'";
        $result = mysql_query( $sql );

        /**
         *  if there is no result, then the login has failed so return false
         */
        if (!$result || mysql_numrows( $result ) < 1) {
            $this->login_text = 'Login Failed';
            return false;
        }

        /**
         *  If the username and password are correct, collate the results
         *  into an array, then extract the array out into its individual
         *  components
         */
        $row = mysql_fetch_array( $result );
        extract( $row );

        /**
         *  Register session variables
         */
        $session->userdata  = $session->getUserdata( $username );
        $session->username  = $_SESSION['username'] = $session->userdata['username'];
        $session->sess_id   = $_SESSION['sess_id']  = session_id();

        /**
         *  set the last login, login count and sess_id  for the user
         */
        $count = $login_count + 1;
        $this->setLogin( $count, $uid );

        /**
         *  if the user has selected the remember me option, then the sess_id
         *  and username needs to be remembered, so two cookies are set with
         *  the expiration period and path having been set in config.inc.php
         */
        if($rem) {
            setcookie('username', $session->username, time()+ $cookie['expire'], $cookie['path']);
            setcookie('sess_id',  $session->sess_id,  time()+ $cookie['expire'], $cookie['path']);
        }

        /**
         *  add a file to the phpBB forum that adds the users IP to the ip array
         *  so that they can view the forum
          
         $forumFile = $fs_root . "members/fsf/logged_in/{$session->username}.php";
         $forumFile = fopen($forumFile, 'w') or die('can\'t open file');
         $user = "<?php
         \$ip['{$session->username}'] = '{$ip}';";
         fwrite($forumFile, $user);
         fclose($forumFile);
         */
        $this->login_text = 'Login Successful - Welcome back ' . $session->userdata['forename'];
        return true;
    }
     
     
     
    function setLogin( $count, $uid )
    {
        global $tbl, $session;

        $sql = "UPDATE {$tbl['users']}
                SET sess_id = '{$session->sess_id}', 
                     last_logon = NOW(), 
                     login_count = {$count}
                WHERE uid = {$uid}";
        $result = mysql_query( $sql );

        return $result;
    }
     
     
     
    function logout()
    {
        global $cookie, $session;

        /**
         *  Start by deleting any cookies used to remember the login session
         */
        if(isset($_COOKIE['username']) && isset($_COOKIE['sess_id'])) {
            setcookie('username', '', time()- $cookie['expire'], $cookie['path']);
            setcookie('sess_id',   '', time()- $cookie['expire'], $cookie['path']);
        }

        /**
         *  delete the file that allows the current ip address access to the
         *  forum
         */
        $forumFile = $fs_root . "members/fsf/logged_in/{$session->username}.php";
        $forumFile = fopen($forumFile, 'w');
        fclose($forumFile);
        print $forumFile;
        $forumFile = $fs_root . "members/fsf/logged_in/{$session->username}.php";
        unlink($forumFile);


        /**
         *  then unset the PHP session
         */
        unset($_SESSION['username']);
        unset($_SESSION['sess_id']);


        /**
         *  change the $session->logged_in to false showing the user is logged
         *  out
         */
        $session->logged_in = false;


        /**
         *  ensure the user is set as a guest
         */
        $session->username = 'Guest';
        $session->userdata = '';
        $session->sess_id  = '';

        $this->login_text = 'Logged out successfully';
    }
     
     

    /**
     *  Inserts the basic details of a new user into the batabase
     *
     *  @param array $row  An array holding the values submitted using the form
     *  @return boolean    Returns whether the function has failed or not
     */
    function newUser( $row )
    {
        global $tbl;
        extract($row);

        /**
         * check that the username hasn't already been taken
         */
        $sql = 'SELECT username
                FROM ' . $tbl['users'] . '  
                WHERE username = "' . $username . '"';
        $result = mysql_query( $sql );

        /**
         * if the query finds a result, then the username has been taken
         */
        if ($result) {
            $this->error = 'Username already taken';
            return false;
        }

        /**
         *  as users can only be added by administrators, there should be
         *  no need to check the username, password, userlevel or category
         *  for SQL code injection so just add the user to the database
         */
        $sql = "INSERT INTO {$tbl['users']}
                  (forename,
                   surname,
                   dob,
                   username, 
                   password, 
                   userlevel, 
                   category)
                VALUES ('{$forename}', 
                        '{$surname}', 
                        '{$dob}', 
                        '{$username}', 
                        '{$password}', 
                        '{$userlevel}', 
                        '{$category}')";
        $result = mysql_query( $sql );

        return $result;
    }
     
     
     
    function removeUser( $user )
    {
        global $tbl;

        /**
         *  Change the users category to deleted rather that delete them fully
         */
        $sql = "UPDATE {$tbl['users']}
                SET category = 'deleted' 
                WHERE username = '{$user}'
                LIMIT 1";
        $result = mysql_query( $sql );

        return $result;
    }
     
     
     
    function editDetails( $userdata )
    {
        global $tbl;

        $sql = "UPDATE {$tbl['users']}
                SET forename = '{$userdata['forename']}', 
                    surname  = '{$userdata['surname']}', 
                    nickname = '{$userdata['nickname']}', 
                    dob      = '{$userdata['dob']}', 
                    address  = '{$userdata['address']}', 
                    phone    = '{$userdata['phone']}', 
                    mobile   = '{$userdata['mobile']}', 
                    email    = '{$userdata['email']}', 
                    sdesc    = '{$userdata['sdesc']}',
                    img      = '{$userdata['img']}' 
                WHERE uid    = '{$userdata['uid']}' 
                LIMIT 1";
        $result = mysql_query( $sql );

        return $result;
    }
}
