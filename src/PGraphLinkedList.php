<?php

/**
 * The extension of SplDoublyLinkedList used to simulate a queue used
 * in Dijkstra's Algorithm. Even though the Fibonacci Heap would be
 * the best choice for a queue, SPL didn't have one and implementation
 * would've taken much longer.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Linked_List
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $package_id$
 * @link      http://pear.php.net/package/PGraph
 * @since     File available since Release 1.0
 */

/**
 * Extension of the SPLDoublyLinkedList class.
 * 
 * @category  PGGraphLinkedList
 * @package   PGraph
 * @author    Vilius Zaikauskas <zaikaus1@gmail.com>
 * @copyright 2013 Vilius Zaikauskas
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PGraph
 * @since     Class available since Release 1.0
 */
class PGraphLinkedList extends SplDoublyLinkedList
{

    /**
     * Removes the vertex with the smallest 
     * distance value and returns it.
     * 
     * @param array $distances The distance values
     *                         of vertices.
     * 
     * @return mixed Index of the vertex with the smallest
     *               distance value. NULL if the distances
     *               array is empty.
     */
    public function popClosest(array $distances)
    {
        
        $closestIndex = null;
        $closest = null;
        $distance = null;
        
        
        foreach ($this as $index => $vertex) {
            
            // We need to make sure I can find
            // a closer vertex.
            if (isset($distances[$vertex])
                && ($closest == null 
                || $distances[$vertex] < $distance)
            ) {
                $closest = $vertex;
                $closestIndex = $index;
                $distance = $distances[$vertex];
            }
        }
        
        
        // If our index is not null
        // we pop that entry from this data structure.
        if (!is_null($closestIndex)) {
            $this->offsetUnset($closestIndex);
        }

        
        
        return $closest;
    }
    
}

?>
