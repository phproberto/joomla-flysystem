<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;

/**
 * ClassWithEvents tests.
 *
 * @since   __DEPLOY_VERSION__
 */
abstract class TestWithEvents extends \TestCaseDatabase
{
	/**
	 * Events called by the filesystem.
	 *
	 * @var  array
	 */
	protected $calledEvents = [];

	/**
	 * Dispatcher instance for testing purposes.
	 *
	 * @var  \JEventDispatcher
	 */
	protected $dispatcher;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->saveFactoryState();

		Factory::$config      = $this->getMockConfig();
		Factory::$session  = $this->getMockSession();

		$this->dispatcher      = new \JEventDispatcher;
		\TestReflection::setValue($this->dispatcher, 'instance', $this->dispatcher);

		$app = $this->getMockForAbstractClass(CMSApplication::class);
		$app->loadDispatcher($this->dispatcher);

		Factory::$application = $app;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return  void
	 */
	protected function tearDown()
	{
		$this->restoreFactoryState();

		parent::tearDown();

		\TestReflection::setValue($this->dispatcher, 'instance', null);

		$this->calledEvents = [];
	}
}
