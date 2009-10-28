<?php
declare(ENCODING = 'utf-8');
namespace F3\TYPO3CR\NodeType;

/*                                                                        *
 * This script belongs to the FLOW3 package "TYPO3CR".                    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Test the NodeTypeIterator implementation.
 *
 * @version  $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class NodeTypeIteratorTest extends \F3\Testing\BaseTestCase {

	/**
	 * Tests if getSize() returns the correct size.
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 */
	public function getSizeReturnsCorrectResult() {
		$iterator = new \F3\TYPO3CR\NodeType\NodeTypeIterator(array(
			new \F3\TYPO3CR\NodeType\NodeType('SuperDuperNodeType'),
			new \F3\TYPO3CR\NodeType\NodeType('SuperDuperNodeType')
		));
		$size = $iterator->getSize();
		$this->assertEquals(2, $size, "getSize() does not return correct number.");
	}

	/**
	 * Tests if valid() and nextNode() see all elements
	 *
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 */
	public function hasNextAndNextNodeIterateThroughAllElements() {
		$iterator = new \F3\TYPO3CR\NodeType\NodeTypeIterator(array(
			new \F3\TYPO3CR\NodeType\NodeType('SuperDuperNodeType'),
			new \F3\TYPO3CR\NodeType\NodeType('SuperDuperNodeType')
		));
		$count = 0;
		while ($iterator->valid()) {
			$iterator->nextNodeType();
			$count++;
		}
		$this->assertEquals(2, $count, "valid() and nextNode() do not iterate over all elements.");
	}

	/**
	 * Tests if a OutOfBoundsException is thrown when nextNodeType()
	 * is called and there are no (more) nodetypes available.
	 *
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 * @expectedException \OutOfBoundsException
	 */
	public function throwsOutOfBoundsExceptionIfNoNodesAvailable() {
		$iterator = new \F3\TYPO3CR\NodeType\NodeTypeIterator();
		$iterator->nextNodeType();
	}
}
?>