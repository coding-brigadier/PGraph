<?php

/**
 * The main PGraph file. This is where all the functions used
 * by the users are.
 *
 * PHP version 5.3
 *
 * @category  Main
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://vzaikauskas.com/licenses/MIT.txt MIT
 * @version   GIT: $package_id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */



/**
 * Class autoloader for PGraph
 *
 * @param string $name The name of the class to load.
 *
 * @return void
 */
spl_autoload_register(
    function ($name) {
        // First check this folder
        $path = __DIR__ . '/' . $name . '.php';

        if (file_exists($path)) {
            include $path;
            return;
        }

        // If none of the folders worked, we can include the exceptions folder
        include "Exceptions/Exceptions.php";

    }
);



/**
 * The main PGraph class that is intended for
 * user usage.
 * 
 * @category  PGraph
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://vzaikauskas.com/licenses/MIT.txt MIT
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraph implements Iterator, ArrayAccess, Countable
{

    const STACK = "SplStack";
    const QUEUE = "SplQueue";



    /**
     *
     * @var array A vertex list.
     */
    private $_vertices;

    /**
     *
     * @var boolean This graph is either directed 
     *              or undirected.
     */
    private $_directed;

    /**
     *
     * @var int The number of negative weight edges.
     */
    private $_negativeWeights;

    
    /**
     * A constructor to create the PGraph.
     * 
     * @param boolean $directed TRUE if we want to the graph to be directed.
     *                          FALSE if we want it to be undirected.
     *                          (Default: TRUE)
     */
    public function __construct($directed = true)
    {
        $this->_vertices = array();
        $this->_directed = $directed;
        $this->_negativeWeights = 0;
    }

    /**
     * Gives the number of vertices.
     * 
     * @return int The number of vertices.
     */
    public function count()
    {
        return count($this->_vertices);
    }

    /**
     * Gets the value of the currently pointed vertex.
     * 
     * @return mixed The value that is in the 
     *               currently pointed vertex.
     */
    public function current()
    {
        $currValue = current($this->_vertices);
        return $currValue->getData();
    }

    /**
     * The index of the current vertex element.
     * 
     * @return mixed The index of the currently pointed
     *               vertex.
     */
    public function key()
    {
        return key($this->_vertices);
    }

    /**
     * Move the pointer to the next vertex.
     * 
     * @return void
     */
    public function next()
    {
        next($this->_vertices);
    }

    /**
     * Move the pointer to an array of vertices
     * to the beginning.
     * 
     * @return void
     */
    public function rewind()
    {
        reset($this->_vertices);
    }

    /**
     * Check if the array pointer is pointing to a valid
     * array slot.
     * 
     * @return boolean TRUE if the current pointer is
     *                 pointing the valid slot.
     *                 FALSE, otherwise.
     */
    public function valid()
    {
        return (current($this->_vertices) !== false);
    }

    /**
     * Check if the vertex with a given index exists.
     * 
     * @param mixed $index The index of the vertex.
     * 
     * @return boolean TRUE if the vertex with a given index
     *                 exists. FALSE, otherwise.
     */
    public function offsetExists($index)
    {
        return isset($this->_vertices[$index]);
    }

    /**
     * Get the value of the vertex.
     * 
     * @param mixed $index The index we are accessing.
     * 
     * @throws NoVertexException
     * 
     * @return mixed The data value. NULL, if the there is no value
     *                 basedon the given index.
     */
    public function offsetGet($index)
    {

        // If the value doesn't exist,
        // we return NULL.
        if (!isset($this->_vertices[$index])) {
            $args = array(PGraphException::ARG_INDEX => $index);
            throw new PGraphNoVertexException($args);
        }

        // Otherwise get the vertex
        // and return the data contained
        // in the vertex.
        $vertex = $this->_vertices[$index];

        return $vertex->getData();
    }

    /**
     * Add the vertex to the vertext array.
     * 
     * @param mixed $index The index of the vertex.
     * @param mixed $value The data contained in the vertex.
     * 
     * @return void
     */
    public function offsetSet($index, $value)
    {
        $this->_vertices[$index] = new PGraphVertex($value);
    }

    /**
     * Unset the array element.
     * 
     * @param mixed $index the index of an element to unset.
     * 
     * @throws NoVertexException
     * 
     * @return void
     */
    public function offsetUnset($index)
    {

        // We can unset the vertex only if it exists.
        if (isset($this->_vertices[$index])) {

            // For each vertex, make sure this vertex
            // is no longer neighboring.
            foreach ($this->_vertices as &$vertex) {

                $neighbors = $vertex->getNeighbors();

                if (isset($neighbors[$index])) {
                    $vertex->removeNeighbor($index);
                }
            }

            // Feel free to unset the vertex.
            unset($this->_vertices[$index]);
        } else {
            $args = array(PGraphException::ARG_INDEX => $index);
            throw new PGraphNoVertexException($args);
        }
    }

    /**
     * Add an edge between two vertices (if it doesn't exist).
     * 
     * @param mixed $srcIndex The index of the first vertex.
     *                        If the graph is undirected, the edge
     *                        GOES FROM this vertex.
     * @param mixed $dstIndex The index of the second vertex.
     *                        If the graph is directed, the edge
     *                        GOES INTO this vertex.
     * @param float $weight   The weight of the edge (Default: 0).
     * 
     * @throws NoVertexException
     * @throws EdgeExistsException 
     * 
     * @return void
     */
    public function addEdge($srcIndex, $dstIndex, $weight = 0)
    {

        // Check if both vertices exist.
        if ($this->_vertexExists($srcIndex) === false) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif ($this->_vertexExists($dstIndex) === false) {
            $args = array(PGraphException::ARG_INDEX => $dstIndex);
            $exception = 'PGraphNoVertexException';
        } elseif ($this->_edgeExists($srcIndex, $dstIndex) === true) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex, 
                PGraphException::ARG_INDEX2 => $dstIndex
            );
            $exception = 'PGraphEdgeExistsException';
        }
        
        // If we have an argument array,
        // then we must throw an exception.
        if (isset($args)) {
            throw new $exception($args);
        }


        $srcVertex = $this->_vertices[$srcIndex];
        $dstVertex = $this->_vertices[$dstIndex];

        // Add an edge from vertex index1 to vertex index2.
        $srcVertex->addNeighbor($dstIndex, $dstVertex, $weight);

        // If it's an undirected graph, there should be an edge
        // going the other way.
        if ($this->_directed === false) {
            $dstVertex->addNeighbor($srcIndex, $srcVertex, $weight);
        }

        // If the weight is negative,
        // we increment the counter.
        if ($weight < 0) {
            $this->_negativeWeights++;
        }
    }
    
    /**
     * Provided the given vertices and the edge between them
     * exists, change the weight of the edge.
     * 
     * @param mixed $srcIndex  The index of a vertex from which the edge
     *                         GOES FROM.
     * @param mixed $dstIndex  The index of a vertex to which the edge
     *                         GOES TO.
     * @param float $newWeight The new weight of the edge. 
     * 
     * @throws NoVertexException
     * @throws NoEdgeException
     * 
     * @return void
     */
    public function setWeight($srcIndex, $dstIndex, $newWeight)
    {        
        if (!isset($this->_vertices[$srcIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif (!isset($this->_vertices[$dstIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif ($this->_edgeExists($srcIndex, $dstIndex) === false) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex,
                PGraphException::ARG_INDEX => $dstIndex
            );
            $exception = 'PGraphNoEdgeException';
        }
        
        if (isset($args)) {
            throw new $exception($args);
        }
        
        // Grab the verteces.
        $srcVertex = $this->_vertices[$srcIndex];
        $dstVertex = $this->_vertices[$dstIndex];
        
        // Set the vertex weight.
        $srcVertex->setWeight($dstIndex, $newWeight);
        
        
        // If it's directed, we need to change the weight
        // of the vertex going the other way.
        if ($this->_directed === false) {
            $dstVertex->setWeight($srcIndex, $newWeight); 
        }
        
        
    }
    
    /**
     * Change the value of the already existing vertex.
     *  
     * @param mixed $index    The index of the vertex.
     * @param mixed $newValue The new value that the vertex should contain.
     * 
     * @throws NoVertexException
     * 
     * @return void
     */
    public function setVertex($index, $newValue)
    {
        if (!isset($this->_vertices[$index])) {
            $args = array(PGraphException::ARG_INDEX => $index);
            throw new PGraphNoVertexException($args);
        }
        
        $this->_vertices[$index] = $newValue;
    }

    /**
     * Remove the edge (if exists).
     * 
     * @param mixed $srcIndex The index from which the edge GOES FROM.
     * @param mixed $dstIndex The index to which the edge GOES TO.
     * 
     * @return void
     */
    public function removeEdge($srcIndex, $dstIndex)
    {
        if (!isset($this->_vertices[$srcIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif (!isset($this->_vertices[$dstIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif ($this->_edgeExists($srcIndex, $dstIndex) === false) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex,
                PGraphException::ARG_INDEX => $dstIndex
            );
            $exception = 'PGraphNoEdgeException';
        }
        
        
        if (isset($args)) {
            throw new $exception($args);
        }
        
        
        // If we get to this point, we can remove the edge.

        $srcVertex = $this->_vertices[$srcIndex];
        $dstVertex = $this->_vertices[$dstIndex];

        // If the weight was negative, subtract
        // the negative weight counter.
        if ($srcVertex->getWeight($dstIndex) < 0) {
            $this->_negativeWeights--;
        }

        $srcVertex->removeNeighbor($dstIndex);

        // If it's undirected, we need to remove the edge going
        // the opposite direction.
        if ($this->_directed === false) {
            $dstVertex->removeNeighbor($srcIndex);
        }

    }

    /**
     * Add a new vertex into the graph.
     * 
     * @param mixed $index The index of the next vertex
     * @param mixed $value The value that the vertex will contain.
     * 
     * @throws VertexExistsException
     * 
     * @return void
     */
    public function addVertex($index, $value)
    {        
        if (!isset($this->_vertices[$index])) {
            $this->offsetSet($index, $value);
        } else {
            $args = array(PGraphException::ARG_INDEX, $index);
            throw new PGraphVertexExistsException($args);
        }
    }

    /**
     * Remove the vertex if it exists.
     * 
     * @param mixed $index The index of the vertex we want to remove.
     * 
     * @throws NoVertexException
     * 
     * @return void
     */
    public function removeVertex($index)
    {
        if (isset($this->_vertices[$index])) {
            $this->offsetUnset($index);
        } else {
            $args = array(PGraphException::ARG_INDEX, $index);
            throw new PGraphNoVertexException($args);
        }
    }

    /**
     * Get the value of the vertex.
     * 
     * @param mixed $index The index of the vertex.
     * 
     * @throws NoVertexException
     * 
     * @return mixed The value of the vertex.
     */
    public function getVertex($index)
    {
        return $this->offsetGet($index);
    }
    
    /**
     * Returns the weight of the edge.
     * 
     * @param mixed $srcIndex The vertex connected via an edge.
     * @param mixed $dstIndex The vertex connected via an edge.
     * 
     * @throws NoVertexException
     * @throws NoEdgeException
     * 
     * @return float The weight of the edge.
     *               FALSE if the edge doesn't exist.
     */
    public function getWeight($srcIndex, $dstIndex)
    {
        if (!isset($this->_vertices[$srcIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif (!isset($this->_vertices[$dstIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
            $exception = 'PGraphNoVertexException';
        } elseif ($this->_edgeExists($srcIndex, $dstIndex) === false) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex,
                PGraphException::ARG_INDEX2 => $dstIndex
            );
            $exception = 'PGraphNoEdgeException';
        }
        
        
        if (isset($args)) {
            throw new $exception($args);
        }
        
        $srcVertex = $this->_vertices[$srcIndex];
        $weights = $srcVertex->getWeights();
        
        return $weights[$dstIndex];
        
    }

    /**
     * Find the shortest path between two vertices.
     *
     * @param mixed $srcIndex The start vertex.
     * @param mixed $dstIndex The destination vertex.
     * 
     * @throws NoVertexException
     * @throws NoPathException
     * @throws NegativeCycleException
     *
     * @return array The path between the source and the
     *               destination. FALSE if there is no path
     *               or there is a negative-weight cycle.
     *
     */
    public function shortestPath($srcIndex, $dstIndex)
    {
        // Check if both vertices exist.
        if (!isset($this->_vertices[$srcIndex])) {
            $args = array(PGraphException::ARG_INDEX => $srcIndex);
        } else if (!isset($this->_vertices[$dstIndex])) {
            $args = array(PGraphException::ARG_INDEX => $dstIndex);
        }
        
        // If at least one vertex doesn't exist
        // throw an exception
        if (isset($args)) {
            throw new PGraphNoVertexException($args);
        }
        
        if ($this->_negativeWeights == 0) {
            return $this->_dijkstra($srcIndex, $dstIndex); 
        } else {
            return $this->_bellmanFord($srcIndex, $dstIndex);
        }
    }

    /**
     * Perform a Depth First Search starting from the given
     * vertex.
     *
     * @param mixed $index The index of the starting vertex.
     * 
     * @throws NoVertexException
     *
     * @return array All the vertices traversed.
     */
    public function depthFirstSearch($index)
    {
        $list = new SplStack();
        return $this->_traverseGraph($index, $list);
    }

    /**
     * Perform a Breadth First Search starting from the given
     * vertex.
     *
     * @param mixed $index The index of the starting vertex.
     * 
     * @throws NoVertexException
     *
     * @return array All the vertices traversed.
     */
    public function breadthFirstSearch($index)
    {
        $list = new SplQueue();
        return $this->_traverseGraph($index, $list);
    }
    
    /**
     * Get all the neighboring vertices of the given vertex.
     *
     * @param mixed $index An index of the vertex.
     *
     * @throw NoVertexException
     * 
     * @return array All the neighbors of the given vertex.
     */
    public function getNeighbors($index)
    {
        // If the vertex doesn't exist,
        // throw an exception.
        if ($this->_vertexExists($index) === false) {
            $args = array(PGraphException::ARG_INDEX => $index);
            throw new PGraphNoVertexException($args);
        }
        
        $vertex = $this->_vertices[$index];
        
        return $vertex->getNeighbors();
    }

    /**
     * Check if the vertex with a given index exists.
     *
     * @param mixed $index The index of the vertex.
     *
     * @return boolean TRUE if the vertex exists.
     *                 FALSE otherwise.
     *
     */
    private function _vertexExists($index)
    {
        return isset($this->_vertices[$index]);
    }

    /**
     * Check if there is an edge between two vertices.
     *
     * @param mixed $srcIndex The vertex from which the edge
     *                        GOES FROM.
     * @param mixed $dstIndex The vertex to which the edge
     *                        GOES TO.
     *
     * @return boolean TRUE if the edge exists.
     *                 FALSE otherwise.
     */
    private function _edgeExists($srcIndex, $dstIndex)
    {
        $srcNeighbors = $this->_vertices[$srcIndex]->getNeighbors();

        return isset($srcNeighbors[$dstIndex]);
    }

    /**
     * A helper function used to perform either Depth First Search
     * or Breadth First Search.
     * 
     * @param mixed               $index The index of the starting vertex.
     * @param SplDoublyLinkedList $list  Considering the usage of this 
     *                                    function, it'll be either a 
     *                                    Stack or Queue, depending
     *                                    on whether it's a 
     *                                    Depth First Search or
     *                                    Breadth First Search.
     * 
     * @return array The list of vertices traversed. FALSE, if the vertex
     *                 doesn't exist.
     */
    private function _traverseGraph($index, SplDoublyLinkedList $list)
    {
        // If the vertex doesn't exist, set an error
        // and return FALSE.
        if ($this->_vertexExists($index) === false) {
            $args = array(PGraphException::ARG_INDEX => $index);
            throw new PGraphNoVertexException($args);
        }


        // Created the array where we will keep visited vertices.
        $vertices = array();


        self::_addToList($index, $list);

        while ($list->isEmpty() === false) {
            $currIndex = self::_removeFromList($list);
            $currVertex = $this->_vertices[$currIndex];
            
            if (isset($vertices[$currIndex])) {
                continue;
            }

            $vertices[$currIndex] = $currVertex;


            $neighbors = $currVertex->getNeighbors();
            $nIndeces = array_keys($neighbors);

            foreach ($nIndeces as $nIndex) {
                self::_addToList($nIndex, $list);
            }
        }

        $vertexIndeces = array_keys($vertices);

        return $vertexIndeces;
    }

    /**
     * Add the value into the linked list.
     * 
     * @param mixed               $index The index of a vertex.
     * @param SplDoublyLinkedList &$list Considering the usage,
     *                                   this will either be a Stack 
     *                                   or a Queue.
     * 
     * @return void
     */
    private static function _addToList($index, SplDoublyLinkedList &$list)
    {
        $objectType = get_class($list);

        if ($objectType == self::STACK) {

            $list->push($index);
        } elseif ($objectType == self::QUEUE) {
            $list->enqueue($index);
        }
    }

    /**
     * Remove an element from the Stack or Queue.
     * 
     * @param SplDoublyLinkedList &$list Considering the usage, this will
     *                                   either be a Stack or a Queue.
     * 
     * @return mixed The index of a vertex that we removed from the list.
     *               NULL, if the type of the list is not recognized.
     */
    private static function _removeFromList(SplDoublyLinkedList &$list)
    {
        $objectType = get_class($list);

        if ($objectType == self::STACK) {

            return $list->pop();
        } elseif ($objectType == self::QUEUE) {

            return $list->dequeue();
        }

        // If we can't recognize the type of the list,
        // we return null
        return null;
    }
    
    /*
     * The following are the shorted path algorithms.
     * If there are no negative edges, Dijkstra's algorithm
     * will be invoked. If there exists at least 1 negative
     * edge, then Bellman-Ford gets invoked. 
     */
    
    /**
     * If there are no negative weight edges,
     * use Dijkstra's algorithm to find the
     * shortest path between two vertices.
     * 
     * SOURCE: wikipedia.org
     * 
     * @param mixed $srcIndex The starting vertex.
     * @param mixed $dstIndex The destination vertex.
     * 
     * @throws NoPathException
     * 
     * @return array The path between two vertices.
     */
    private function _dijkstra($srcIndex, $dstIndex)
    {          
        $previous = array();
        $dist = array();
        
        
        $queue = new PGraphLinkedList(); 
        
        $queue->push($srcIndex);
        $dist[$srcIndex] = 0;
        
        $vertices = array_keys($this->_vertices);
        
        foreach ($vertices as $vIndex) {
            $previous[$vIndex] = null;
            
            if ($vIndex != $srcIndex) {
                $queue->push($vIndex);
            }
            
        }


        while ($queue->isEmpty() === false) {
            
            $currIndex = $queue->popClosest($dist);
           
            
            if (is_null($currIndex)) {
                $args = array(
                    PGraphException::ARG_INDEX1 => $srcIndex,
                    PGraphException::ARG_INDEX2 => $dstIndex
                );
                
                throw new PGraphNoPathException($args);
            }
            
            if ($currIndex == $dstIndex) {
                break;
            }
           
            
            $currVertex = $this->_vertices[$currIndex];
           
            
            $neighbors = $currVertex->getNeighbors();
            $weights = $currVertex->getWeights();
            
            $nIndeces = array_keys($neighbors);
            
      
            
            foreach ($nIndeces as $nIndex) {
                $weight = $weights[$nIndex];
                
                $alt = $dist[$currIndex] + $weight;
                if (!isset($dist[$nIndex])
                    || $alt < $dist[$nIndex]
                ) {
                    $dist[$nIndex] = $alt;
                    $previous[$nIndex] = $currIndex;
                    $dist[$nIndex] = $alt;
                }
            }
            
            
  
        }
 
        $sequence = array();
        $currIndex = $dstIndex;
        
        while (isset($previous[$currIndex])) {
            $sequence[] = $currIndex;
            $currIndex = $previous[$currIndex];
        }
        
        if ($currIndex != $srcIndex) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex,
                PGraphException::ARG_INDEX2 => $dstIndex
            );
            throw new PGraphNoPathException($args);
        }
        
        $sequence[] = $srcIndex;
        
        $finalSequence = array_reverse($sequence);
        
        return $finalSequence;
        
        
    }
    
    /**
     * If there is at least one negative weight edge,
     * this is used to find the shortest path between
     * two vertices.
     * 
     * @param mixed $srcIndex The starting vertex.
     * @param mixed $dstIndex The destination vertex.
     * 
     * @throws NoPathException
     * @throws NegativeCycleException
     * 
     * @return array The path between two vertices.
     *               FALSE if there is no path or
     *               a negative cycle has been
     *               detected.
     */
    private function _bellmanFord($srcIndex, $dstIndex)
    {
        $dist = array();
        $prev = array();
        
        
        $vertices = array_keys($this->_vertices);
        
        foreach ($vertices as $vIndex) {
            if ($vIndex == $srcIndex) {
                $dist[$vIndex] = 0;
            }
            
            $prev[$vIndex] = null;
        }
        
        for ($i = 0; $i < count($vertices); $i++) {
            foreach ($vertices as $vIndex) {
                if (!isset($dist[$vIndex])) {
                    continue; 
                }
                
                
                $currVertex = $this->_vertices[$vIndex];
                
                $neighbors = $currVertex->getNeighbors();
                $weights = $currVertex->getWeights();
                
                $nIndeces = array_keys($neighbors);
                
                foreach ($nIndeces as $nIndex) {
                    $currWeight = $weights[$nIndex];
                    
                    if (!isset($dist[$nIndex])
                        || $dist[$vIndex] + $currWeight < $dist[$nIndex]
                    ) {
                        
                        $dist[$nIndex] = $dist[$vIndex] + $currWeight;
                        $prev[$nIndex] = $vIndex;
                       
                    }
                }
            }
        }
        
        foreach ($vertices as $vIndex) {
                
            $currVertex = $this->_vertices[$vIndex];
                
            $neighbors = $currVertex->getNeighbors();
            $weights = $currVertex->getWeights();
            
            $nIndeces = array_keys($neighbors);
            
            foreach ($nIndeces as $nIndex) {
                $weight = $weights[$nIndex];
                
                if ($dist[$vIndex] + $weight < $dist[$nIndex]) {
                    throw new PGraphNegativeCycleException();
                }
            }
        }
        
        $sequenceRev = array();
        
        $currIndex = $dstIndex;
        
        while (isset($prev[$currIndex])) {
            $sequenceRev[] = $currIndex;
            $currIndex = $prev[$currIndex];
        }
        
        if ($currIndex != $srcIndex) {
            $args = array(
                PGraphException::ARG_INDEX1 => $srcIndex,
                PGraphException::ARG_INDEX2 => $dstIndex
            );
            throw new PGraphNoPathException($args);
        }
        
        $sequenceRev[] = $srcIndex;
        
        $sequence = array_reverse($sequenceRev);
        
        return $sequence;
    }    
}
