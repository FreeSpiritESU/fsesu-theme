<?php
/**
 *  A class to allow users to amend their account details.
 *
 *  @author  Richard Perry (richard@perrymail.me.uk)
 *  @version 1.0
 *  @package FreeSpirit
 */

/**
 * Ensures the script is not run independantly of another page
 */
if( !defined('IN_FSW') ) {
    die();
}

class UserAccount extends User
{
    protected $row;

    //functions
     
    /**
     * Runs on initial instantiation of the class ad sets the where clause of
     * the SQL query in the parent class, then runs the getUsers() function and
     * assigns the data to the row variable
     *
     * @param integer $uid
     */
    public function __construct( $uid )
    {
        $this->sql_where = "WHERE uid = $uid";
        $result = parent::getUsers();

        $this->row = mysql_fetch_assoc( $result );
    }




    /**
     * Display the users details on screen
     *
     * @global string $fs_root  Root path
     * @return string           HTML output
     */
    public function displayAccount()
    {
        global $fs_root;

        // extract the data into named variables
        extract( $this->row );

        // convert the dob into the dd/mm/yyyy format
        $dob = date('d/m/Y', strtotime( $dob ));

        // set up the table to display the data
        $account = "
        <table id='user_account'>
        <tr>
        <td class='title'>Forename: </td>
        <td class='data'>{$forename}</td>
        <td class='img' colspan='2' rowspan='4'>
        <img src='{$fs_root}images/{$img}.jpg' title='{$forename} {$surname}' style='width: 144px'/>
        </td>
        </tr>
        <tr>
        <td class='title'>Surname: </td>
        <td class='data'>{$surname}</td>
        </tr>
        <tr>
        <td class='title'>Nickname: </td>
        <td class='data'>{$nickname}</td>
        </tr>
        <tr>
        <td class='title'>Date of Birth: </td>
        <td class='data'>{$dob}</td>
        </tr>
        <tr>
        <td class='title' rowspan='3'>Address: </td>
        <td class='data' rowspan='3'>{$address}</td>
        <td class='title'>Phone Number: </td>
        <td class='data'>{$phone}</td>
        <tr>
        <td class='title'>Mobile Number: </td>
        <td class='data'>{$mobile}</td>
        </tr>
        <tr>
        <td class='title'>Email: </td>
        <td class='data'>{$email}</td>
        </tr>
        </table>";

        return $account;
    }



    /**
     * Display the editable user details form
     *
     * @global string $fs_root  Root path
     * @return string           HTML output
     */
    public function displayAccountEdit()
    {
        global $fs_root;

        // extract the data into named variables
        extract( $this->row );

        // convert the dob into the dd/mm/yyyy format
        $dob = date('d/m/Y', strtotime( $dob ));

        // set up the table to display the data
        $account = "
        <form method='post' class='user' id='editAccount' style='display: none' action='{$fs['members']}process.php?editAccount'>
        <table id='user_account'>
        <tr>
        <td class='title'>Forename: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$forename}' id='forename' name='forename' />
        </td>
        <td class='img' colspan='2' rowspan='4'>
        <img src='{$fs_root}images/{$img}.jpg' title='{$forename} {$surname}' style='width: 144px'/>
        </td>
        </tr>
        <tr>
        <td class='title'>Surname: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$surname}' id='surname' name='surname' />
        </td>
        </tr>
        <tr>
        <td class='title'>Nickname: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$nickname}' id='nickname' name='nickname' />
        </td>
        </tr>
        <tr>
        <td class='title'>Date of Birth: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$dob}' id='dob' name='dob' />
        </td>
        </tr>
        <tr>
        <td class='title' rowspan='3'>Address: </td>
        <td class='data' rowspan='3'>
        <textarea class='userTextarea' id ='address' name='adress' rows='3' cols='50'>{$address}</textarea>
        </td>
        <td class='title'>Phone Number: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$phone}' id='phone' name='phone' />
        </td>
        <tr>
        <td class='title'>Mobile Number: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$mobile}' id='mobile' name='mobile' />
        </td>
        </tr>
        <tr>
        <td class='title'>Email: </td>
        <td class='data'>
        <input class='userInput' type='text' value='{$email}' id='email' name='email' />
        </td>
        </tr>
        </table>";

        return $account;
    }
}