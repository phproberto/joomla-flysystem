<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit\Adapter;

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
		$this->calledEvents = [];

		\JFactory::$application->registerEvent('onFlysystemBeforeLoadAdapter', [$this, 'onFlysystemBeforeLoadAdapter']);
		\JFactory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);

		$config = ['sample' => 'setting'];
		$adapter = new JoomlaFolder('media', $config);

		// Test onFlysystemBeforeLoadAdapter result
		$this->assertTrue(isset($this->calledEvents['onFlysystemBeforeLoadAdapter']));
		$this->assertSame($adapter, $this->calledEvents['onFlysystemBeforeLoadAdapter'][0]);
		$this->assertSame(JPATH_SITE . '/media', $this->calledEvents['onFlysystemBeforeLoadAdapter'][1]);
		$this->assertInstanceOf(CMSApplication::class, $this->calledEvents['onFlysystemBeforeLoadAdapter'][2]);

		// Test onFlysystemAfterLoadAdapter result
		$this->assertTrue(isset($this->calledEvents['onFlysystemAfterLoadAdapter']));
		$this->assertSame($adapter, $this->calledEvents['onFlysystemAfterLoadAdapter'][0]);
		$this->assertSame(JPATH_SITE . '/media', $this->calledEvents['onFlysystemAfterLoadAdapter'][1]);
		$this->assertInstanceOf(CMSApplication::class, $this->calledEvents['onFlysystemAfterLoadAdapter'][2]);
		$this->assertSame('modified', $adapter->config()->get('sample'));
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
	 * @param   JoomlaFolder    $adapter  Adapter being instatiated
	 * @param   string          $path     Path being loaded
	 * @param   CMSApplication  $app      Application running the adapter
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadAdapter(JoomlaFolder $adapter, &$path, CMSApplication $app)
	{
		$this->calledEvents['onFlysystemBeforeLoadAdapter'] = func_get_args();

		$adapter->config()->set('sample', 'modified');
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   JoomlaFolder    $adapter  Adapter being instatiated
	 * @param   string          $path     Path being loaded
	 * @param   CMSApplication  $app      Application running the adapter
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadAdapter(JoomlaFolder $adapter, $path, CMSApplication $app)
	{
		$this->calledEvents['onFlysystemAfterLoadAdapter'] = func_get_args();

		$this->assertSame('modified', $adapter->config()->get('sample'));
	}
}
