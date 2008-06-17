<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package TYPO3CR
 * @subpackage Tests
 * @version $Id:F3_TYPO3CR_Storage_Backend_TestBase.php 888 2008-05-30 16:00:05Z k-fish $
 */

/**
 * Tests for the storage backend implementations of TYPO3CR. Needs to be extended
 * for various storage types
 *
 * @package TYPO3CR
 * @subpackage Tests
 * @version $Id:F3_TYPO3CR_Storage_Backend_TestBase.php 888 2008-05-30 16:00:05Z k-fish $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_TYPO3CR_Storage_Backend_TestBase extends F3_Testing_BaseTestCase {

	/**
	 * @var F3_TYPO3CR_Storage_BackendInterface
	 */
	protected $storageAccess;

	/**
	 * Checks if we can store and remove a raw node properly.
	 * @author Sebastian Kurfuerst <sebastian@typo3.org>
	 * @test
	 */
	public function addNodeAndRemoveNodeWork() {
		$identifier = F3_FLOW3_Utility_Algorithms::generateUUID();
		$expectedRawNode = array(
			'parent' => '96bca35d-1ef5-4a47-8b0c-0bfc69507d00',
			'name' => 'TestNode1',
			'identifier' => $identifier,
			'nodetype' => 'nt:base'
		);
		$this->storageAccess->addNode($identifier, '96bca35d-1ef5-4a47-8b0c-0bfc69507d00', 'nt:base', 'TestNode1');
		$rawNode = $this->storageAccess->getRawNodeByIdentifier($identifier);
		$this->assertTrue(is_array($rawNode), 'getRawNodeByIdentifier() did not return an array for a just created node entry.');
		$this->assertSame($expectedRawNode, $rawNode, 'The returned raw node had not the expected values.');

		$this->storageAccess->removeNode($identifier);
		$rawNode = $this->storageAccess->getRawNodeByIdentifier($identifier);
		$this->assertFalse($rawNode, 'getRawNodeByIdentifier() did return an array for a just removed node entry.');
	}

	/**
	 * Checks if we can update and remove a raw node properly
	 * @author Sebastian Kurfuerst <sebastian@typo3.org>
	 * @test
	 */
	public function updateNodeAndRemoveNodeWork() {
		$identifier = F3_FLOW3_Utility_Algorithms::generateUUID();
		$expectedRawNode = array(
			'parent' => '96bca35d-1ef5-4a47-8b0c-0bfc69507d00',
			'name' => 'TestNode2',
			'identifier' => $identifier,
			'nodetype' => 'nt:base'
		);
		$this->storageAccess->addNode($identifier, '96bca35d-1ef5-4a47-8b0c-0bfc69507d00', 'nt:base', 'TestNode2');
		$rawNode = $this->storageAccess->getRawNodeByIdentifier($identifier);
		$this->assertTrue(is_array($rawNode), 'getRawNodeByIdentifier() did not return an array for a just created node entry.');
		$this->assertSame($expectedRawNode, $rawNode, 'The returned raw node had not the expected values.');

		$expectedRawNodeUpdated = array(
			'parent' => '96bca35d-1ef5-4a47-8b0c-0bfc69507d01',
			'name' => 'TestNode2Updated',
			'identifier' => $identifier,
			'nodetype' => 'nt:unstructured'
		);
		$this->storageAccess->updateNode($identifier, '96bca35d-1ef5-4a47-8b0c-0bfc69507d01', 'nt:unstructured', 'TestNode2Updated');
		$rawNodeUpdated = $this->storageAccess->getRawNodeByIdentifier($identifier);
		$this->assertTrue(is_array($rawNodeUpdated), 'getRawNodeByIdentifier() did not return an array for an updated node entry.');
		$this->assertSame($expectedRawNodeUpdated, $rawNodeUpdated, 'The returned raw node had not the expected (updated) values.');

		$this->storageAccess->removeNode($identifier);
		$rawNode = $this->storageAccess->getRawNodeByIdentifier($identifier);
		$this->assertFalse($rawNode, 'getRawNodeByIdentifier() did return an array for a just removed node entry.');
	}

	/**
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 */
	public function addNodeTypeAndDeleteNodeTypeWork() {
		$nodeTypeTemplate = new F3_TYPO3CR_NodeType_NodeTypeTemplate();
		$nodeTypeTemplate->setName('testNodeType');

		$expectedRawNodeType = array(
			'name' => 'testNodeType'
		);
		$this->storageAccess->addNodeType($nodeTypeTemplate);
		$rawNodeType = $this->storageAccess->getRawNodeType('testNodeType');
		$this->assertTrue(is_array($rawNodeType), 'getRawNodeType() did not return an array for a just created nodetype entry.');
		$this->assertSame($expectedRawNodeType, $rawNodeType, 'The returned raw node had not the expected values.');

		$this->storageAccess->deleteNodeType('testNodeType');
		$rawNodeType = $this->storageAccess->getRawNodeType('testNodeType');
		$this->assertFalse($rawNodeType, 'getRawNodeType() did return an array for a just removed nodetype entry.');
	}

}
?>