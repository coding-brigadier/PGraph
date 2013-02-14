<?php

/**
 * Test cases for the PGraph library.
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Directed_Graph_Core
 * @package   PGraph
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
 * Test cases for undirected graphs.
 * 
 * @category  PGraphUndirectedTest
 * @package   PGraphTests
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphUndirectedTest extends PHPUnit_Framework_TestCase
{

    /**
     * Check if we even create an empty graph.
     * 
     * @return void
     */
    public function testEmpty()
    {
        $graph = new PGraph(false);

        $this->assertTrue(isset($graph));
        $this->assertEquals(get_class($graph), "PGraph");
    }
    
    
    /**
     * Test if the count() function works on a graph.
     * 
     * @return void
     */
    public function testCount1()
    {
        $graph = new PGraph(false);
        
        $graph->addVertex(4, "val");
        $graph[5] = "test";
        $graph->addVertex("yay", "index?");
        $graph["this index"] = 42;
        
        $this->assertEquals(count($graph), 4);  
        
    }
    
    /**
     * Test if the count() instance function works on a graph.
     * 
     * @return void
     */
    public function testCount2()
    {
        $graph = new PGraph(false);
        
        $graph->addVertex(4, "val");
        $graph[5] = "test";
        $graph->addVertex("yay", "index?");
        $graph["this index"] = 42;
        
        $this->assertEquals($graph->count(), 4);  
        
    }


    /**
     * Check if we successfully create a graph
     * with one vertex.
     * 
     * @return void
     */
    public function testOneVertex()
    {
        $graph = new PGraph(false);
        
        
        $graph->addVertex(4, "data");

        $this->assertEquals(count($graph), 1);
        $this->assertEquals($graph->getVertex(4), "data");
    }


    /**
     * Test a graph with two vertices
     * that are not connected.
     * 
     * @return void
     */
    public function testTwoVertices()
    {
        $graph = new PGraph(false);
        
        $graph->addVertex(4, "data");
        
        $graph["index"] = "other data";

        $this->assertEquals(count($graph), 2);
        $this->assertEquals($graph[4], "data");
        $this->assertEquals($graph["index"], "other data");
    }


    /**
     * Test a graph with two vertices connected
     * via an edge.
     * 
     * @return void
     */
    public function testOneEdge()
    {
        $graph = new PGraph(false);
        
              
        $graph->addVertex(4, "data");
        $graph["index"] = "other data";
        $graph->addVertex(5, "even more data");

        $graph->addEdge(4, 5);


        $neighbors = $graph->getNeighbors(4);

        $this->assertEquals(count($neighbors), 1);
        $this->assertTrue(isset($neighbors[5]));
        $this->assertEquals($neighbors[5]->getData(), "even more data");
        
        $neighbors2 = $graph->getNeighbors(5);
        
        $this->assertEquals(count($neighbors2), 1);
        $this->assertTrue(isset($neighbors2[4]));
        $this->assertEquals($neighbors2[4]->getData(), "data");


    }


    /**
     * Test a graph with more vertices
     * and more edges.
     * 
     * @return void
     */
    public function testMultipleEdges()
    {
        $graph = new PGraph(false);
        
              
        $graph->addVertex(4, "data");
        $graph["index"] = "other data";
        $graph->addVertex(5, "even more data");

        $graph->addEdge(4, 5);
        $graph->addEdge(4, "index");
        
        $neighbors = $graph->getNeighbors(4);

        
        $this->assertEquals(count($neighbors), 2);
        $this->assertTrue(isset($neighbors["index"]));
        $this->assertEquals($neighbors["index"]->getData(), "other data");
        
        
    }
    
    /**
     * Check if we are able to create a weighted edge.
     * 
     * @return void
     */
    public function testOneWeightedEdge()
    {
        $graph = new PGraph(false);

        $graph[4] = "vertex 1";
        $graph[5] = "vertex 2";
        
        $graph->addEdge(4, 5, 24.5);
        
        $neighbors = $graph->getNeighbors(4);
        $weight = $graph->getWeight(4, 5);
        
        $this->assertEquals(count($neighbors), 1);
        $this->assertEquals($weight, 24.5);
        
    }
    
    /**
     * Check if we are able to change the vertex value.
     * 
     * @return void
     */
    public function testChangeVertexValue()
    {
        $graph = new PGraph(false);
        
        $graph[5] = "value";
        
        $this->assertEquals($graph[5], "value");        
        
        $graph[5] = "different value";
        
        $this->assertEquals($graph[5], "different value");
        
    }
    
    /**
     * Try to change the weight of an existing edge.
     * 
     * @return void
     */
    public function testSetWeight()
    {
        $graph = new PGraph(false);
        
        $graph[4] = "vertex1";
        $graph[5] = "vertex2";
        
        $graph->addEdge(4, 5, 2);
        ;
        
        $this->assertEquals($graph->getWeight(4, 5), 2);
        $this->assertEquals($graph->getWeight(5, 4), 2);
        
        $graph->setWeight(4, 5, 42);
        
        
        $this->assertEquals($graph->getWeight(4, 5), 42);
        $this->assertEquals($graph->getWeight(5, 4), 42);
    }
    
    /**
     * Test if we are able to remove a vertex.
     * 
     * @return void
     */
    public function testRemoveVertex()
    {
        $graph = new PGraph(false);
        
        $graph[4] = "other";
        
        $this->assertEquals($graph[4], "other");
        
        $graph->removeVertex(4);
        
        $this->assertTrue(!isset($graph[4]));
    }
    
    /**
     * Check if we are able to remove a vertex
     * that has outgoing and ingoing edges.
     * 
     * @return void
     */
    public function testRemoveVertexWithEdges()
    {
        $graph = new PGraph(false);
        
        $graph[4] = "vertex 1";
        $graph[5] = "vertex 2";
        $graph[6] = "vertex 3";
        $graph[7] = "vertex 4";
        
        $graph->addEdge(4, 5, 24.5);
        $graph->addEdge(4, 6, 32);
        $graph->addEdge(5, 6, 211);
        $graph->addEdge(7, 4, 3111);
        
        $this->assertTrue(isset($graph[4]));
        
        $graph->removeVertex(4);
        
        $neighbors5 = $graph->getNeighbors(5);
        $neighbors6 = $graph->getNeighbors(6);
        $neighbors7 = $graph->getNeighbors(7);
        
        $this->assertTrue(!isset($graph[4]));
        
        $this->assertEquals(count($neighbors5), 1);
        $this->assertEquals(count($neighbors6), 1);
        $this->assertEquals(count($neighbors7), 0);
        
        
    }
    
    /**
     * Test Depth First Search.
     * 
     * @return void
     */
    public function testDFS()
    {
        $graph = new PGraph(false);
        
        for ($i = 0; $i < 15; $i++) {
            $graph[$i] = $i;
        }
        
        $graph->addEdge(0, 5, 321);
        $graph->addEdge(0, 2);
        $graph->addEdge(2, 7, 23121);
        $graph->addEdge(5, 10, 1);
        $graph->addEdge(10, 2, 3);
        $graph->addEdge(2, 14);
        $graph->addEdge(14, 7, 312);
        
        
        $sequence = $graph->depthFirstSearch(0);

        $expectedSequence = array(
            0, 
            2,
            14,
            7, 
            10, 
            5
        );


        
        $this->assertEquals($sequence, $expectedSequence);
    }
    
    /**
     * Test Breadth First Search.
     * 
     * @return void
     */
    public function testBFS()
    {
        $graph = new PGraph(false);
        
        for ($i = 0; $i < 15; $i++) {
            $graph[$i] = $i;
        }
        
        $graph->addEdge(0, 5, 321);
        $graph->addEdge(0, 2);
        $graph->addEdge(2, 7, 23121);
        $graph->addEdge(5, 10, 1);
        $graph->addEdge(10, 2, 3);
        $graph->addEdge(2, 14);
        $graph->addEdge(14, 7, 312);
        
        
        $sequence = $graph->breadthFirstSearch(0);
       
        $expectedSequence = array(
            0, 
            5,
            2,
            10,
            7,
            14
        );
        
        $this->assertEquals($sequence, $expectedSequence);
    }
    
    /**
     * Test Dijkstra's algorithm
     * for finding the shortest path.
     * The path in this case exists.
     * 
     * This gets invoked when there are no
     * negative weight edges.
     * 
     * @return void
     */
    public function testDijkstra()
    {
        $graph = new PGraph(false);
        
        for ($i = 0; $i < 37; $i++) {
            $graph[$i] = $i;
        }
        
        $graph->addEdge(0, 5, 321);
        $graph->addEdge(0, 2, 43);
        $graph->addEdge(2, 7, 23121);
        $graph->addEdge(5, 10, 1);
        $graph->addEdge(10, 2, 3);
        $graph->addEdge(2, 14, 21);
        $graph->addEdge(2, 17, 1);
        $graph->addEdge(17, 14, 4);
        $graph->addEdge(14, 36, 123);
        $graph->addEdge(14, 7, 312);
        
        
        $sequence = $graph->shortestPath(0, 36);
        
        $expectedSequence = array(
            0,
            2,
            17,
            14,
            36
        );
        
        $this->assertEquals(count($sequence), count($expectedSequence));
        $this->assertEquals($sequence, $expectedSequence);
    }
    
    

}

