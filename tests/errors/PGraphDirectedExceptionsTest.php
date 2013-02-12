<?php


/**
 * Exception tests for a directed graph.
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  PGraphExceptionsTests
 * @package   PGraphTests
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $package_id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */

$mainFile = "../../src/PGraph.php";

if (file_exists($mainFile)) {
    include_once $mainFile;
}

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Contains all the exceptions cases in directed graphs.
 * 
 * @category  PGraphCoreTests
 * @package   PGraphTests
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphDirectedExceptionsTest extends
        PHPUnit_Framework_TestCase
{
    
    
    /**
     * Getting a non-existent vertex via array access.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentVertexTest1()
    {
        $graph = new PGraph(true);
        
        $graph[4];    
    }
    
    /**
     * Getting a non-existen vertex via a library function.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentVertexTest2()
    {
        $graph = new PGraph();
        
        $graph->getVertex("some interesting index");    
    }
    
    /**
     * Attempt to unset a non-existent vertex via unset().
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetUnsetNonExistentVertex1()
    {
        $graph = new PGraph();
        
        unset($graph[12]);
    }
    
    /**
     * Attempt to unset a non-existent vertex via offsetUnset().
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetUnsetNonExistentVertex2()
    {
        $graph = new PGraph();
        
        $graph->offsetUnset($graph["another index"]);
    }
    
    /**
     * Attempt to add an edge when one vertex is missing.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testAddEdgeException1()
    {
        $graph = new PGraph(true);
        
        $graph[4] = "test vertex";
        
        $graph->addEdge(5, 4);
    }
    
    /**
     * Attempt to add an edge when one vertex is missing.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testAddEdgeException2()
    {
        $graph = new PGraph();
        
        $graph[10] = "test vertex";
        
        $graph->addEdge(10, 42);
    }
    
    /**
     * Attempt to add an edge when the edge already exists.
     * 
     * @expectedException EdgeExistsException
     * 
     * @return void
     */
    public function testAddEdgeException3()
    {
        $graph = new PGraph(true);
        
        $graph["index1"] = "test vertex";
        $graph["index2"] = "another test vertex";
        
        $graph->addEdge("index1", "index2");
        
        // Since this edge exists, this should
        // throw an Exception
        $graph->addEdge("index1", "index2");
    }
    
    /**
     * Attempt to set the weight with a non-existen vertex.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testSetWeightException1()
    {
        $graph = new PGraph();
        
        $graph[4] = "test";
        
        $graph->setWeight(5, 4, 7);
    }
    
    /**
     * Attempt to set the weight with a non-existen vertex.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testSetWeightException2()
    {
        $graph = new PGraph();
        
        $graph["index"] = "vertex";
        
        $graph->setWeight("index", 2, 2);
    }
    
    /**
     * Attempt to set the weight on a non-existent edge.
     * 
     * @expectedException NoEdgeException
     * 
     * @return void
     */
    public function testSetWeightException3()
    {
        $graph = new PGraph(true);
        
        $graph["this index"] = "vertex #1";
        $graph[1] = "vertex #2";
        
        $graph->setWeight("this index", 1, 22);
    }
    
    /**
     * Attempt to set a value on a non-existen vertex.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testSetNonExistentVertexData()
    {
        $graph = new PGraph();
        
        $graph->setVertex(4, "test");
    }
    
    /**
     * Attempt to add a vertex that already exists.
     * 
     * @expectedException VertexExistsException
     * 
     * @return void
     */
    public function testAddVertex()
    {
        $graph = new PGraph();
        
        $graph->addVertex(4, "value");
        
        // This will cause an Exception
        // since the vertex already exists.
        $graph->addVertex(4, "some other value");
    }
    
    
    /**
     * Attempt to remove a vertex that doesn't exist.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testRemoveNonexistentVertex()
    {
        $graph = new PGraph();
        
        $graph->removeVertex("key", "value");
    }
    
    /**
     * Attempt to do an array access of a non-existen vertex.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentVertex1()
    {
        $graph = new PGraph();
        
        $graph[4];
    }
    
    /**
     * Attempt to get the value of a non-existent vertex.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentVertex2()
    {
        $graph = new PGraph();
        
        $graph->getVertex("index");
    }
    
    /**
     * Attempt to get the weight of a non-existent edge.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentEdgeWeigh1()
    {
        $graph = new PGraph(true);
        
        $graph[4] = "test";
        
        $graph->getWeight(4, "index");
    }
    
    /**
     * Attempt to get the weight of a non-existent edge.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentEdgeWeight2()
    {
        $graph = new PGraph();
        
        $graph["index"] = "test";
        
        $graph->getWeight("index", 1);
    }
    
    
    /**
     * Attempt to get the weight of a non-existent edge.
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testGetNonExistentEdgeWeight3()
    {
        $graph = new PGraph();
        
        $graph["index"] = "test";
        
        $graph->getWeight("index", 1);
    }
    
    
    /**
     * Attempt to get the weight of a non-existent edge.
     * 
     * @expectedException NoEdgeException
     * 
     * @return void
     */
    public function testGetNonExistentEdgeWeight4()
    {
        $graph = new PGraph();
        
        $graph["index"] = "test";
        $graph["other index"] = "test vertex";
        
        $graph->getWeight("index", "other index");
    }
    
    /**
     * Test the shortest path algorithm when there is no
     * destination vertex. 
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testShortestPathException1()
    {
        $graph = new PGraph();
        
        $graph[4] = "test";
        
        $graph->shortestPath(4, "no index");
    }
    
    /**
     * Test the shortest path algorithm when there is no
     * source vertex. 
     * 
     * @expectedException NoVertexException
     * 
     * @return void
     */
    public function testShortestPathException2()
    {
        $graph = new PGraph();
        
        $graph["index"] = "test";
        
        $graph->shortestPath(12, "index");
    }
    
    
    /**
     * Test the shortest path algorithm when there is no
     * path.
     * 
     * @expectedException NoPathException
     * 
     * @return void
     */
    public function testDijkstrasShortestPathException()
    {
        $graph = new PGraph();
        
        $graph[4] = "vertex1";
        $graph["index"] = "vertex2";
        $graph["Vilius"] = "Zaikauskas";
        $graph["YES"] = "NO";
        $graph[32] = 31;
        $graph["42"] = 1;
        
        $graph->addEdge(4, 32, 321);
        $graph->addEdge(4, "42", 1);
        $graph->addEdge("42", 32, 319);
        $graph->addEdge(32, "Vilius", 21);
        
        
        $graph->shortestPath(4, "index");
    }
    
    /**
     * Test the shortest path algorithm when there is no
     * path.
     * 
     * @expectedException NoPathException
     * 
     * @return void
     */
    public function testBellmanFordShortestPathException1()
    {
        $graph = new PGraph();
        
        $graph[4] = "vertex1";
        $graph["index"] = "vertex2";
        $graph["Vilius"] = "Zaikauskas";
        $graph["YES"] = "NO";
        $graph[32] = 31;
        $graph["42"] = 1;
        
        $graph->addEdge(4, 32, 321);
        $graph->addEdge(4, "42", 1);
        $graph->addEdge("42", 32, -14);
        $graph->addEdge(32, "Vilius", 21);
        
        
        $graph->shortestPath(4, "index");
    }
    
    
    /**
     * Test the shortest path algorithm when there is a
     * negative weight cycle.
     * 
     * @expectedException NegativeCycleException
     * 
     * @return void
     */
    public function testBellmanFordShortestPathException2()
    {
        $graph = new PGraph();
        
        $graph[4] = "vertex1";
        $graph["index"] = "vertex2";
        $graph["Vilius"] = "Zaikauskas";
        $graph["YES"] = "NO";
        $graph[32] = 31;
        $graph["42"] = 1;
        
        $graph->addEdge(4, 32, 321);
        $graph->addEdge("Vilius", "42", -400);
        $graph->addEdge("42", 4, 1);
        $graph->addEdge("42", 32, -14);
        $graph->addEdge(32, "Vilius", -21);
        
        
        $graph->shortestPath(4, "index");
    }    
    
    
}
