<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit\Adapter;

use Joomla\CMS\Factory;
use League\Flysystem\AdapterInterface;
use Joomla\CMS\Application\CMSApplication;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;

/**
 * JoomlaFolder adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class JoomlaFolderTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  JoomlaFolder
	 */
	private $adapter;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		Factory::$application->registerEvent('onFlysystemBeforeLoadAdapter', [$this, 'onFlysystemBeforeLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemBeforeLoadJoomlaFolderAdapter', [$this, 'onFlysystemBeforeLoadJoomlaFolderAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadJoomlaFolderAdapter', [$this, 'onFlysystemAfterLoadJoomlaFolderAdapter']);

		$this->adapter = new JoomlaFolder('media', ['sample' => 'setting']);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorSetsPath()
	{
		$reflection = new \ReflectionClass($this->adapter);
		$pathPrefixProperty = $reflection->getProperty('pathPrefix');
		$pathPrefixProperty->setAccessible(true);

		$this->assertSame(JPATH_SITE . '/media/', $pathPrefixProperty->getValue($this->adapter));
	}

	/**
	 * Constructor triggers events.
	 *
	 * @return  void
	 */
	public function testConstructorTriggersEvents()
	{
		$expectedTriggeredEvents = [
			'onFlysystemBeforeLoadAdapter',
			'onFlysystemBeforeLoadJoomlaFolderAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadJoomlaFolderAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));
		$this->assertTrue($this->adapter->config()->get('onFlysystemAfterLoadJoomlaFolderAdapter'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function canReadFile()
	{
		$this->assertTrue($this->adapter->has('jui/js/jquery.min.js'));
	}

	/**
	 * Triggered before adapter has been loaded.
	 *
	 * @param   AdapterInterface  $adapter  Adapter being instatiated
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadAdapter(AdapterInterface $adapter)
	{
		$this->assertNull($adapter->config()->get('onFlysystemBeforeLoadAdapter'));

		$this->calledEvents['onFlysystemBeforeLoadAdapter'] = func_get_args();

		$adapter->config()->set('onFlysystemBeforeLoadAdapter', true);
	}

	/**
	 * Triggered before adapter has been loaded.
	 *
	 * @param   JoomlaFolder   $adapter  Adapter being instatiated
	 * @param   string         $path     Path being loaded
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadJoomlaFolderAdapter(JoomlaFolder $adapter, &$path)
	{
		$this->assertTrue($adapter->config()->get('onFlysystemBeforeLoadAdapter'));
		$this->assertNull($adapter->config()->get('onFlysystemBeforeLoadJoomlaFolderAdapter'));

		$this->calledEvents['onFlysystemBeforeLoadJoomlaFolderAdapter'] = func_get_args();

		$adapter->config()->set('onFlysystemBeforeLoadJoomlaFolderAdapter', true);
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   AdapterInterface  $adapter  Adapter being instatiated
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadAdapter(AdapterInterface $adapter)
	{
		$this->assertTrue($adapter->config()->get('onFlysystemBeforeLoadJoomlaFolderAdapter'));
		$this->assertNull($adapter->config()->get('onFlysystemAfterLoadAdapter'));

		$this->calledEvents['onFlysystemAfterLoadAdapter'] = func_get_args();

		$adapter->config()->set('onFlysystemAfterLoadAdapter', true);
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   JoomlaFolder  $adapter  Adapter being instatiated
	 * @param   string        $path     Path being loaded
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadJoomlaFolderAdapter(JoomlaFolder $adapter, $path)
	{
		$this->assertTrue($adapter->config()->get('onFlysystemAfterLoadAdapter'));
		$this->assertNull($adapter->config()->get('onFlysystemAfterLoadJoomlaFolderAdapter'));

		$this->calledEvents['onFlysystemAfterLoadJoomlaFolderAdapter'] = func_get_args();

		$adapter->config()->set('onFlysystemAfterLoadJoomlaFolderAdapter', true);
	}
}
