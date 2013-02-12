<?php
/**
 * The Generic PGraph Exception class.
 * All valid Exceptions will extend this class. 
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Exceptions
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */



/**
 * The main Exception class that is intended for
 * being the benchmark for all Exceptions.
 * 
 * @category  PGraphException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphException extends Exception
{
    /**
     *
     * @var array Exception messages.
     */
    private static $_messages = null;
    
    /**
     * PGraphException Constructor.
     * 
     * @param array $args  Values to be embedded into
     *                     the messages. 
     * @param int   $index The Exception message index.
     */
    public function __construct($args, $index) 
    {
        self::_initMessages();
        
        $message = self::$_messages[$index];
        
        foreach ($args as $key => $value) {
            $replace = "{{ " . $key . " }}";
            
            $message
                = str_replace($replace, $value, $message);
        }
        
        parent::__construct($message, $index);
        
    }
    
    /**
     * Initialize the $_messages array if
     * it hasn't been done so.
     * 
     * @return void
     */
    private static function _initMessages()
    {
        if (self::$_messages == null) {
            self::$_messages = array(   
                
               NO_VERTEX => "A vertex with index {{ " 
                          . ARG_INDEX . " }} does not exist.",
                
               NO_EDGE => "An edge between vertices {{ " 
                        . ARG_INDEX1 . " }} and {{ " . ARG_INDEX2 
                        . " }} doesn't exist.",
                
               EDGE_EXISTS => "An edge between vertices {{ " 
                            . ARG_INDEX1 . " }} and {{ " . ARG_INDEX2 
                            . " }} already exists.",
                
               NO_PATH => "There is no path between " 
                        . "vertices {{ " . ARG_INDEX1 
                        . " }} and {{ " . ARG_INDEX2 . " }}.",
                
               BAD_TYPE => "The type of an argument " 
                         . "passed is invalid.",   
               
               NEG_CYCLE => "There is a negative-weight " 
                          . "cycle in this graph.",
                
               VERTEX_EXISTS => "The vertex {{ " . ARG_INDEX
                              . " }} already exists."
                
            ); 
        }
    }
}
