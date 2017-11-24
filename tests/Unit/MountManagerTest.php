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
use League\Flysystem\Adapter\Local;
use Joomla\CMS\Application\CMSApplication;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\MountManager;
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
	 * Filesystems loaded by default.
	 *
	 * @var  array
	 */
	private $coreFileSystems = ['cache', 'log', 'joomla', 'tmp'];

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
				'log_path'   => __DIR__ . '/Stubs/logs',
				'tmp_path'   => __DIR__ . '/Stubs/tmp'
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

	/**
	 * @test
	 *
	 * @return void
	 */
	public function canReadFiles()
	{
		$this->assertTrue($this->manager->has('cache://testCache.txt'));
		$this->assertTrue($this->manager->has('joomla://htaccess.txt'));
		$this->assertTrue($this->manager->has('log://testLog.txt'));
		$this->assertTrue($this->manager->has('tmp://testTmp.txt'));
		$this->assertTrue($this->manager->has('test://' . basename(__FILE__)));
	}

	/**
	 * Constructor triggers events.
	 *
	 * @return  void
	 */
	public function testConstructorTriggersEvents()
	{
		$this->calledEvents = [];

		\JFactory::$application->registerEvent('onFlysystemBeforeLoadMountManager', [$this, 'onFlysystemBeforeLoadMountManager']);
		\JFactory::$application->registerEvent('onFlysystemAfterLoadMountManager', [$this, 'onFlysystemAfterLoadMountManager']);

		$manager = new MountManager;

		// Test onFlysystemBeforeLoadMountManager result
		$this->assertTrue(isset($this->calledEvents['onFlysystemBeforeLoadMountManager']));
		$this->assertSame($manager, $this->calledEvents['onFlysystemBeforeLoadMountManager'][0]);
		$this->assertEquals($this->coreFileSystems, array_keys($this->calledEvents['onFlysystemBeforeLoadMountManager'][1]));
		$this->assertInstanceOf(CMSApplication::class, $this->calledEvents['onFlysystemBeforeLoadMountManager'][2]);

		// Test onFlysystemAfterLoadMountManager result
		$this->assertTrue(isset($this->calledEvents['onFlysystemAfterLoadMountManager']));
		$this->assertSame($manager, $this->calledEvents['onFlysystemAfterLoadMountManager'][0]);
		$this->assertEquals(array_merge($this->coreFileSystems, ['test']), array_keys($this->calledEvents['onFlysystemAfterLoadMountManager'][1]));
		$this->assertInstanceOf(CMSApplication::class, $this->calledEvents['onFlysystemAfterLoadMountManager'][2]);
	}

	/**
	 * Triggered before MountManager has been loaded.
	 *
	 * @param   MountManager      $mountManager  Loaded MountManager
	 * @param   array             $filesystems   Filesystems being loaded
	 * @param   CMSApplication    $app           Application loading the manager
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadMountManager(MountManager $mountManager, array &$filesystems, CMSApplication $app)
	{
		$this->calledEvents['onFlysystemBeforeLoadMountManager'] = func_get_args();

		$folder = __DIR__;
		$adapter = new Local($folder);
		$filesystems['test'] = new Filesystem($adapter);
	}

	/**
	 * Triggered after MountManager has been loaded.
	 *
	 * @param   MountManager      $mountManager  Loaded MountManager
	 * @param   array             $filesystems   Filesystems already loaded
	 * @param   CMSApplication    $app           Application loading the manager
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadMountManager(MountManager $mountManager, array $filesystems, CMSApplication $app = null)
	{
		$this->calledEvents['onFlysystemAfterLoadMountManager'] = func_get_args();
	}
}
