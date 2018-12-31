<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Adapter;

use Phproberto\Joomla\Flysystem\Adapter\BlockedLocal;
use Phproberto\Joomla\Flysystem\Tests\Adapter\Traits\IsBlockedInsideRoot;
use LogicException;

/**
 * BlockedLocal tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class BlockedLocalTest extends \TestCase
{
	use IsBlockedInsideRoot;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->adapter = new BlockedLocal(__DIR__ . '/Stubs');
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function canRead()
	{
		$this->assertTrue($this->adapter->has('file.txt'));
	}

	/**
	 * @test
	 *
	 * @return void
	 *
	 * @expectedException  LogicException
	 */
	public function cannotReadOutside()
	{
		$this->assertFalse($this->adapter->has(basename(__FILE__)));

		$this->adapter->has('../' . basename(__FILE__));
	}
}
