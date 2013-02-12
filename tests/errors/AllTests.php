<?php

/**
 * All exceptions test suites combined into one file.
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  AllExceptionsTests
 * @package   PGraphTests
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $package_id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */

require_once "PGraphDirectedExceptionsTest.php";
require_once "PGraphUndirectedExceptionsTest.php";

/**
 * The class that contains all the functionality
 * combining all the exceptions suites.
 * 
 * @category  PGraphExceptionsTests
 * @package   PGraphTests
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphExceptionsTests
{

    /**
     * This gets invoked when we run PHPUnit.
     * 
     * @return void
     */
    public static function main()
    {
        PHPUnit2_TextUI_TestRunner::run(self::suite());    
    }
    
    
    /**
     * Include all test suites.
     * 
     * @return PHPUnit_Framework_TestSuite The full suite.
     */    
    public static function suite()
    {
        $core = new PHPUnit_Framework_TestSuite('PGraph Errors');
        
        $core->addTestSuite('PGraphDirectedExceptionsTest');
        $core->addTestSuite('PGraphUndirectedExceptionsTest');
        
        return $core;
    }
    
}