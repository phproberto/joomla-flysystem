<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Adapter;

use LogicException;
use Joomla\CMS\Factory;
use League\Flysystem\AdapterInterface;
use Joomla\CMS\Application\CMSApplication;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;
use Phproberto\Joomla\Flysystem\Tests\TestWithEvents;
use Phproberto\Joomla\Flysystem\Tests\Adapter\Traits\IsBlockedInsideRoot;

/**
 * JoomlaFolder adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class JoomlaFolderTest extends TestWithEvents
{
	use IsBlockedInsideRoot;

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
	 * @test
	 *
	 * @return void
	 */
	public function defaultParamsAreLoaded()
	{
		$this->assertSame(LOCK_EX, $this->adapter->param('writeFlags'));
		$this->assertSame(JoomlaFolder::DISALLOW_LINKS, $this->adapter->param('linkHandling'));
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

		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadJoomlaFolderAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadJoomlaFolderAdapter'));

		$this->assertSame('onFlysystemBeforeLoadJoomlaFolderAdapter', $this->adapter->param('modifiedConfig'));
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
		$this->calledEvents['onFlysystemBeforeLoadAdapter'] = func_get_args();

		$adapter->setParam('onFlysystemBeforeLoadAdapter', true);
	}

	/**
	 * Triggered before adapter has been loaded.
	 *
	 * @param   JoomlaFolder   $adapter  Adapter being instatiated
	 * @param   string         $path     Path being loaded
	 * @param   string         $config   Configuration for the adapter
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadJoomlaFolderAdapter(JoomlaFolder $adapter, string &$path, array &$config)
	{
		$this->calledEvents['onFlysystemBeforeLoadJoomlaFolderAdapter'] = func_get_args();

		$config['modifiedConfig'] = __FUNCTION__;
		$adapter->setParam('onFlysystemBeforeLoadJoomlaFolderAdapter', true);
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
		$this->calledEvents['onFlysystemAfterLoadAdapter'] = func_get_args();

		$adapter->setParam('onFlysystemAfterLoadAdapter', true);
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   JoomlaFolder  $adapter  Adapter being instatiated.
	 * @param   string        $path     Path being loaded.
	 * @param   string        $config   Configuration for the adapter.
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadJoomlaFolderAdapter(JoomlaFolder $adapter, string $path, array $config)
	{
		$this->calledEvents['onFlysystemAfterLoadJoomlaFolderAdapter'] = func_get_args();

		$adapter->setParam('onFlysystemAfterLoadJoomlaFolderAdapter', true);
	}
}
