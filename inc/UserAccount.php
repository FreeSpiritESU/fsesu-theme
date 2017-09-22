<?php
/**
*  A class to allow users to amend their account details.
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

class UserAccount extends User
{
    protected $row;
    
    //functions
   
   /**
    * Runs on initial instantiation of the class ad sets the where clause of 
    * the SQL query in the parent class, then runs the getUsers() function and 
    * assigns the data to the row variable
    */
    public function __construct( $uid )
    {
        parent::sql_where = "WHERE uid = $uid";
        $result = parent::getUsers();
        
        $this->row = mysql_fetch_assoc( $result );
    }
    
    
    
      
   /**
    * display the users details on screen
    */
    public function displayAccount()
    {
        // extract the data into named variables
        extract( $this->row );
        
        // convert the dob into the dd/mm/yyyy format
        $dob = date('d/m/Y', $dob);
        
        // set up the table to display the data
        $account = "
            <table id='user_account'>
                <tr>
                    <td style='width: 100px'>Forename: </td>
                    <td style='width: 350px'>{$forename}</td>
                    <td colspan='2' rowspan='4'>
                        <img src='{$fs_root}images/{$img}.jpg' title='{$forename} {$surname}' />
                    </td>
                </tr>
                <tr>
                    <td>Surname: </td>
                    <td>{$surname}</td>
                </tr>
                <tr>
                    <td>Nickname: </td>
                    <td>{$nickname}</td>
                </tr>
                <tr>
                    <td>Date of Birth: </td>
                    <td>{$dob}</td>
                </tr>
                <tr>
                    <td rowspan='3'>Address: </td>
                    <td rowspan='3'>{$address}</td>
                    <td style='width: 100px'>Phone Number: </td>
                    <td style='width: 350px'>{$phone}</td>
                <tr>
                    <td>Mobile Number: </td>
                    <td>{$mobile}</td>
                </tr>
                <tr> 
                    <td>Email: </td>
                    <td>{$email}</td>
                </tr>
             </table>";
        
        return $account;
    }
    
    
    view account
    edit account