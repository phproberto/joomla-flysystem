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
use Phproberto\Joomla\Flysystem\Adapter\WebDAV;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;
use Sabre\DAV\Client;

/**
 * WebDAV adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class WebDAVTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  WebDAV
	 */
	private $adapter;

	/**
	 * Test server configuration.
	 *
	 * @var  array
	 */
	private $testServerConfig = [
		'baseUri'     => 'http://localhost'
	];

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
		Factory::$application->registerEvent('onFlysystemBeforeLoadWebDAVAdapter', [$this, 'onFlysystemBeforeLoadWebDAVAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadWebDAVAdapter', [$this, 'onFlysystemAfterLoadWebDAVAdapter']);

		$this->adapter = new WebDAV(new Client($this->testServerConfig));
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
			'onFlysystemBeforeLoadWebDAVAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadWebDAVAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$reflection = new \ReflectionClass($this->adapter);
		$pathPrefixProperty = $reflection->getProperty('pathPrefix');
		$pathPrefixProperty->setAccessible(true);

		// Plugin could modify prefix
		$this->assertSame('modifiedPrefix/', $pathPrefixProperty->getValue($this->adapter));

		$reflection = new \ReflectionClass($this->adapter);
		$useStreamedCopyProperty = $reflection->getProperty('useStreamedCopy');
		$useStreamedCopyProperty->setAccessible(true);

		// Plugin could modify $useStreamedCopyProperty
		$this->assertFalse($useStreamedCopyProperty->getValue($this->adapter));
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
	 * @param   WebDAV  $adapter          Adapter being instatiated
	 * @param   Client  $client           WebDAV client
	 * @param   string  $prefix           Optional prefix
	 * @param   bool    $useStreamedCopy  Use streamd copy. defaults to true.
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadWebDAVAdapter(WebDAV $adapter, Client $client, &$prefix = null, &$useStreamedCopy = true)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$prefix = 'modifiedPrefix';
		$useStreamedCopy = false;
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
	 * @param   WebDAV  $adapter          Adapter being instatiated
	 * @param   Client  $client           WebDAV client
	 * @param   string  $prefix           Optional prefix
	 * @param   bool    $useStreamedCopy  Use streamd copy. defaults to true.
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadWebDAVAdapter(WebDAV $adapter, Client $client, $prefix = null, $useStreamedCopy = true)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}
}
