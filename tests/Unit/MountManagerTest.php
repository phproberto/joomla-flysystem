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
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\MountManager;
use Phproberto\Joomla\Flysystem\Adapter\Local;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;

/**
 * MountManager tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class MountManagerTest extends TestWithEvents
{
	/**
	 * Manager used for tests.
	 *
	 * @var  MountManager
	 */
	private $manager;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		Factory::$config = new \JObject(
			[
				'cache_path' => __DIR__ . '/Stubs/cache',
				'log_path' => __DIR__ . '/Stubs/logs',
				'tmp_path' => __DIR__ . '/Stubs/tmp'
			]
		);

		$folder = __DIR__;
		$adapter = new Local($folder);
		$this->manager = new MountManager(['test' => new Filesystem($adapter)]);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorSetsFilesystems()
	{
		$reflection = new \ReflectionClass($this->manager);
		$filesystemsProperty = $reflection->getProperty('filesystems');
		$filesystemsProperty->setAccessible(true);

		$expected = [
			'test',
			'cache',
			'log',
			'joomla',
			'tmp'
		];

		$filesystems = $filesystemsProperty->getValue($this->manager);

		$this->assertEquals($expected, array_keys($filesystems));
	}
}
