<?php
/**
 * FreeSpirit Singleton Base class
 * 
 * 
 * 
 * This file is required by functions.php.
 * 
 * @package        FreeSpiritESU
 * @subpackage     Classes
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2013 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   19 December 2013
 */
abstract class FSESU_Singleton {

    private static $instance = array();
    
    protected function __construct() { }
    
    public static function get_instance() {
        $class = get_called_class();
        if ( !isset( self::$instance[$class] ) ) {
            self::$instance[$class] = new $class();
            self::$instance[$class]->init();     
        }

        return self::$instance[$class];
    }   

    abstract protected function init();      
}