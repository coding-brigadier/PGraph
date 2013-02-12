<?php

/**
 * A collection of Exception classes. 
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
require_once "PGraphException.php";

/**
 * Exception thrown if a vertex doesn't exist.
 * 
 * @category  NoVertexException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class NoVertexException extends PGraphException
{

    /**
     * Constructor to create the NoVertexException.
     * 
     * @param mixed $args The arguments to be embedded into
     *                    the Exception message.
     */
    public function __construct($args)
    {
        parent::__construct($args, NO_VERTEX);
    }

}

/**
 * Exception thrown if an edge between 
 * certain vertices doesn't exist.
 * 
 * @category  NoEdgeException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class NoEdgeException extends PGraphException
{

    /**
     * Constructor to create the NoEdgeException.
     * 
     * @param mixed $args The arguments to be embedded into
     *                    the Exception message.
     */    
    public function __construct($args)
    {
        parent::__construct($args, NO_EDGE);
    }

}

/**
 * Exception thrown if an edge between two vertices
 * exists.
 * 
 * @category  EdgeExistsException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class EdgeExistsException extends PGraphException
{

    /**
     * Constructor to create the EdgeExistsException.
     * 
     * @param mixed $args The arguments to be embedded into
     *                    the Exception message.
     */    
    public function __construct($args)
    {
        parent::__construct($args, EDGE_EXISTS);
    }

}

/**
 * Exception thrown if a vertex exists.
 * 
 * @category  VertexExistsException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class VertexExistsException extends PGraphException
{
    /**
     * Constructor to create the VertexExistsException.
     * 
     * @param mixed $args The arguments to be embedded into
     *                    the Exception message.
     */
    public function __construct($args)
    {
        parent::__construct($args, VERTEX_EXISTS);
    }    
}

/**
 * Exception thrown if there is no path
 * betwee two vertices.
 * 
 * @category  NoPathException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class NoPathException extends PGraphException
{
    
    /**
     * Constructor to create the NoPathException.
     * 
     * @param mixed $args The arguments to be embedded into
     *                    the Exception message.
     */
    public function __construct($args)
    {
        parent::__construct($args, NO_PATH);
    }    
}

/**
 * Exception thrown if the parameter passed has an invalid
 * type.
 * 
 * @category  InvalidTypeException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class InvalidTypeException extends PGraphException
{
    /**
     * Constructor to create the InvalidTypeException.
     */
    public function __construct()
    {
        $emptyArr = array();
        parent::__construct($emptyArr, BAD_TYPE);
    }
}

/**
 * Exception thrown if a graph contains a negative cycle.
 * 
 * @category  NegativeCycleException
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class NegativeCycleException extends PGraphException
{
    /**
     * Constructor to create the NegativeCycleException.
     */
    public function __construct()
    {
        $emptyArr = array();
        parent::__construct($emptyArr, NEG_CYCLE);
    }
}

