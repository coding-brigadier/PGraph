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
 * @license   http://vzaikauskas.com/licenses/MIT.txt MIT
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
 * @license   http://vzaikauskas.com/licenses/MIT.txt MIT
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphException extends Exception
{

    const ARG_INDEX = "index";
    const ARG_INDEX1 = "index1";
    const ARG_INDEX2 = "index2";

    const NO_VERTEX = 1;
    const NO_EDGE = 2;
    const EDGE_EXISTS = 3;
    const VERTEX_EXISTS = 4;
    const NO_PATH = 5;
    const BAD_TYPE = 6;
    const NEG_CYCLE = 7;

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
                
               self::NO_VERTEX => "A vertex with index {{ " 
                                . self::ARG_INDEX . " }} does not exist.",
                
               self::NO_EDGE => "An edge between vertices {{ " 
                              . self::ARG_INDEX1 . " }} and {{ " . self::ARG_INDEX2 
                              . " }} doesn't exist.",
                
               self::EDGE_EXISTS => "An edge between vertices {{ " 
                                  . self::ARG_INDEX1 . " }} and " 
                                  . "{{ " . self::ARG_INDEX2 
                                  . " }} already exists.",
                
               self::NO_PATH => "There is no path between " 
                              . "vertices {{ " . self::ARG_INDEX1 
                              . " }} and {{ " . self::ARG_INDEX2 . " }}.",
                
               self::BAD_TYPE => "The type of an argument " 
                               . "passed is invalid.",   
               
               self::NEG_CYCLE => "There is a negative-weight " 
                                . "cycle in this graph.",
                
               self::VERTEX_EXISTS => "The vertex {{ " . self::ARG_INDEX
                                    . " }} already exists."
                
            ); 
        }
    }
}
