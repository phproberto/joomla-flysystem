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
use Phproberto\Joomla\Flysystem\Adapter\ZipFile;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;
use ZipArchive;

/**
 * ZipFile adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class ZipFileTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  ZipFile
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
		Factory::$application->registerEvent('onFlysystemBeforeLoadZipFileAdapter', [$this, 'onFlysystemBeforeLoadZipFileAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadZipFileAdapter', [$this, 'onFlysystemAfterLoadZipFileAdapter']);

		$this->adapter = new ZipFile(JPATH_SITE . '/test.zip');
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
			'onFlysystemBeforeLoadZipFileAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadZipFileAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$reflection = new \ReflectionClass($this->adapter);
		$pathPrefixProperty = $reflection->getProperty('pathPrefix');
		$pathPrefixProperty->setAccessible(true);

		// Plugin could modify prefix
		$this->assertSame('modifiedPrefix/', $pathPrefixProperty->getValue($this->adapter));

		$archive = (array) $this->adapter->getArchive();

		// Plugin could modify location
		$this->assertSame('test.test.zip', basename($archive['filename']));
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
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}

	/**
	 * Triggered before adapter has been loaded.
	 *
	 * @param   ZipFile     $adapter   Adapter being instatiated
	 * @param   string      $location  Path to the zip file
	 * @param   ZipArchive  $file      Source file.
	 * @param   string      $prefix    Optional prefix
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadZipFileAdapter(ZipFile $adapter, &$location, ZipArchive $file = null, &$prefix = null)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$location = str_replace('.zip', '.test.zip', $location);
		$prefix = 'modifiedPrefix';
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
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   ZipFile     $adapter   Adapter being instatiated
	 * @param   string      $location  Path to the zip file
	 * @param   ZipArchive  $file      Source file.
	 * @param   string      $prefix    Optional prefix
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadZipFileAdapter(ZipFile $adapter, $location, ZipArchive $file = null, $prefix = null)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}
}
