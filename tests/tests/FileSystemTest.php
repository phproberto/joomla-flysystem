<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests;

use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;

/**
 * JoomlaFilesystem tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class FilesystemTest extends TestWithEvents
{
	/**
	 * Testing filesystem.
	 *
	 * @var  JoomlaFilesystem
	 */
	private $filesystem;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		\JFactory::$application->registerEvent('onFlysystemBeforeLoadFilesystem', [$this, 'onFlysystemBeforeLoadFilesystem']);
		\JFactory::$application->registerEvent('onFlysystemAfterLoadFilesystem', [$this, 'onFlysystemAfterLoadFilesystem']);

		$this->filesystem = new Filesystem(new JoomlaFolder);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorSetsAdapter()
	{
		$reflection = new \ReflectionClass($this->filesystem);
		$adapterProperty = $reflection->getProperty('adapter');
		$adapterProperty->setAccessible(true);

		$this->assertInstanceOf(AdapterInterface::class, $adapterProperty->getValue($this->filesystem));
	}

	/**
	 * Constructor triggers events.
	 *
	 * @return  void
	 */
	public function testConstructorTriggersEvents()
	{
		$expectedEvents = [
			'onFlysystemBeforeLoadFilesystem',
			'onFlysystemAfterLoadFilesystem'
		];

		$this->assertEquals($expectedEvents, array_keys($this->calledEvents));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function canReadFile()
	{
		$this->assertTrue($this->filesystem->has('htaccess.txt'));
	}

	/**
	 * Triggered before filesystem has been loaded.
	 *
	 * @param   Filesystem        $filesystem  Loaded environment
	 * @param   AdapterInterface  $adapter     Loaded environment
	 * @param   array             $config      Options to initialise environment
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadFilesystem(Filesystem $filesystem, AdapterInterface &$adapter, &$config = null)
	{
		$this->calledEvents['onFlysystemBeforeLoadFilesystem'] = func_get_args();

		// Ensure that options can be modified
		$config['sample'] = 'modified';
	}

	/**
	 * Triggered after filesystem has been loaded.
	 *
	 * @param   Filesystem        $filesystem  Loaded environment
	 * @param   AdapterInterface  $adapter     Loaded environment
	 * @param   array             $config      Options to initialise environment
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadFilesystem(Filesystem $filesystem, AdapterInterface $adapter, $config = null)
	{
		$this->calledEvents['onFlysystemAfterLoadFilesystem'] = func_get_args();

		$this->assertSame('modified', $config['sample']);
	}
}
