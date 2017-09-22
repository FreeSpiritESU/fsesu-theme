<?php
    define('IN_FSW', true);
    $fs_root = './';
    $page = 'Contact Us';
    
    require_once( $fs_root . 'inc/common.php' );
    require_once( $fs_root . 'inc/classes/User.php' );
    
    $body = '';
         
    $contact = new User;
    $contact->sql_where = "WHERE category = 'leader'";
    $result = $contact->getUsers();
    
    while ( $row = mysql_fetch_assoc( $result ))
    {
        $position = ($row['nickname'] == 'Buff') 
                  ? 'Unit Leader' 
                  : 'Assistant Unit Leader';
        $nickname = ($row['nickname'] == '') 
                  ? '' 
                  : '(' . $row['nickname'] . ') ';
        $body .= "
         <p><span class='b'>$position</span> - {$row['forename']} {$row['surname']} {$nickname}<br /><a href='mailto:{$row['email']}'>{$row['email']}</a></p>";
    }
    
    $body = file_get_contents( $fs_root . 'contact_body.htm' ) . $body;
    
    $tpl =  $fs_root . 'template/default.tpl';
    include_once( $fs_root . 'inc/template.php' );
    print $html;
?>