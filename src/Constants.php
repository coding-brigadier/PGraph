<?php

/**
 * All the constants are defined here.
 *
 * PHP version 5
 *
 * @category  Constants
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://vzaikauskas.com/licenses/MIT.txt MIT
 * @version   GIT: $package_id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */

/* List separator */
define("DELIMITER", ", ");

/* Unrecognizable error */
define("UNKNOWN_ERROR", "An unknown error has occured.");

/* Data Structures */
define("STACK", "SplStack");
define("QUEUE", "SplQueue");

/* Error Numbers */
define("NO_VERTEX", 1);
define("NO_EDGE", 2);
define("EDGE_EXISTS", 3);
define("VERTEX_EXISTS", 4);
define("NO_PATH", 5);
define("BAD_TYPE", 6);
define("NEG_CYCLE", 7);


/* Replacement index in argument arrays */
define("ARG_INDEX", "index");
define("ARG_INDEX1", "index1");
define("ARG_INDEX2", "index2");
    
?>
