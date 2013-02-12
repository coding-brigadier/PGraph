<?php

/**
 * This is where we define the graph vertex file. ALL CLASSES
 * AND FUNCTIONS WRITTEN ARE HERE ARE NOT TO BE INSTANTIATED
 * BY THE USER.
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Graph_Vertex
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */




/**
 * The main PGraph class that is intended for
 * user usage.
 * 
 * @category  PGraphVertex
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphVertex
{

    /**
     *
     * @var mixed The data contained in the vertex.
     */
    private $_data;

    /**
     *
     * @var array The neighboring vertices of the current vertex.
     */
    private $_neighbors;
    
    /**
     *
     *@var array Edge weights of the edges going to the associated
     *           neighbor.
     */
    private $_weights;

    /**
     * The constructor used to create the PGraphVertex object.
     * 
     * @param mixed $data - the data that is to be held by this vertex.
     */
    public function __construct($data)
    {
        $this->_data = $data;
        $this->_neighbors = array();
        $this->_weights = array();
    }

    /**
     * Add an edge going into the given vertex.
     * 
     * @param mixed        $index  the index of the vertex.
     * @param PGraphVertex $vertex the reference to the vertex.
     * @param float        $weight the weight of the edge.
     * 
     * @return void
     */
    public function addNeighbor($index, PGraphVertex $vertex, $weight)
    {
        $this->_neighbors[$index] = $vertex;
        $this->_weights[$index] = $weight;
    }

    /**
     * Remove the edge connecting this vertex
     * and the other vertex.
     * 
     * @param mixed $index the index of the vertex
     *                     to remove.
     * 
     * @return void
     */
    public function removeNeighbor($index)
    {
        if (isset($this->_neighbors[$index])) {
            unset($this->_neighbors[$index]);
            unset($this->_weights[$index]);
        }
    }
    
    /**
     * Get the weight of the neighbor.
     * 
     * @param mixed $index index of the neighbor vertex.
     * 
     * @return float the weight of the specified 
     *               vertex index. FALSE if the vertex
     *               doesn't exist.
     */
    public function getWeight($index)
    {
        if (!isset($this->_weights[$index])) {
            return false;
        }
        
        return $this->_weights[$index];
    }

    /**
     * Return the data that is contained
     * in this vertex.
     * 
     * @return mixed the data contained in this
     *               vertex.
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get the list of neighboring vertices.
     * 
     * @return array The list of neighboring
     *               vertices.
     */
    public function getNeighbors()
    {
        return $this->_neighbors;
    }

    /**
     * Get the edge weights array.
     * 
     * @return array - An array of edge weights. 
     */
    public function getWeights()
    {
        return $this->_weights;
    }

    /**
     * Set the weight of an edge
     * connecting to the other vertex.
     * 
     * @param mixed $index     The vertex index to which
     *                         this edge connects.
     * @param float $newWeight The new edge weight. 
     * 
     * @return void
     */
    public function setWeight($index, $newWeight)
    {
        $this->_weights[$index] = $newWeight;
    }

    


}
