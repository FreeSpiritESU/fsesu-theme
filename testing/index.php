<?php
/**
 * FreeSpirit ESU Website
 *
 * @author     Richard Perry (richard@perrymail.me.uk)
 * @copyright  Copyright (c) 2008, FreeSpirit ESU
 * @version    1.0
 * @package    FreeSpirit
 * @subpackage testing
 */
/**
 *
 */
$info = explode("/",$_SERVER['SCRIPT_NAME']);

switch ($info[3]) {
    case 'test':
        echo "this is a test";
        break;

    case 'umm':
        echo "This is another test";
        break;

    default:
        echo "This is the default statement\n\r";
        print_r($info);
        break;
}
phpinfo()
?>
