<?php
echo 'Needs Configuring';
die();
$conn = mysql_connect( 'localhost', 'dragonnet', 'GBSPm7JH' );
mysql_select_db( 'fsesu', $conn);

$query = "SELECT * 
          FROM fs_users 
          WHERE uid = 49";
$result = mysql_query( $query );


while ($row = mysql_fetch_assoc( $result )) {
    $email = mail("{$row['forename']} {$row['surname']} <{$row['email']}>",
        "FreeSpirit Website Logon Details",
        "<html>
            <head>
                <title>FreeSpirit Website Logon Details</title>
            </head>
            <body>
                <font face='Arial' size='2'>
                <p>{$row['forename']}</p>
                <p>Your logon details for access to the FreeSpirit Website are:</p>
                &nbsp;&nbsp;&nbsp;username: {$row['username']} <br />
                &nbsp;&nbsp;&nbsp;password: {$row['orig_p']}
                <p>To logon, please go to http://www.freespiritesu.org.uk/ and enter you details into the logon box on the right hand side of the page. Once logged in, you will be able to access the details we hold for you, as well as the FreeSpirit Forum. To use the forum you will have to register as you would any other forum.</p>
                <p>Regards</p>
                <p>FreeSpirit ESU</p>
                </font>
            </body>
        </html>",
        "MIME-Version: 1.0 \r\n" .
        "Bcc: richard@perrymail.me.uk \r\n" . 
        "Content-type: text/html; charset=iso-8859-1  \r\n" .
        "From: FreeSpirit ESU <webmaster@freespiritesu.org.uk> \r\n" .
        "Reply-To: FreeSpirit ESU <richard@freespiritesu.org.uk> \r\n" .
        "X-Mailer: PHP/" . phpversion());

    if ($email) {
        $return .= "Email delivered successfully to {$row['email']} <br/>";
    } else {
        $return .= "Email failed to deliver to {$row['email']}<br/>";
    }
}

echo $return;
    