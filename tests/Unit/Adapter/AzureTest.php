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
use Phproberto\Joomla\Flysystem\Adapter\Azure;
use MicrosoftAzure\Storage\Blob\Internal\IBlob;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;

/**
 * Azure tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class AzureTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  Azure
	 */
	private $adapter;

	/**
	 * Test server configuration.
	 *
	 * @var  array
	 */
	private $testServerConfig = [
		'region' => 'us-west-2',
		'version' => 'latest'
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
		Factory::$application->registerEvent('onFlysystemBeforeLoadAzureAdapter', [$this, 'onFlysystemBeforeLoadAzureAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAzureAdapter', [$this, 'onFlysystemAfterLoadAzureAdapter']);

		$endpoint = sprintf(
			'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
			'account-name',
			base64_encode('api-key')
		);

		$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($endpoint);

		$this->adapter = new Azure($blobRestProxy, 'my-container');
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
			'onFlysystemBeforeLoadAzureAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadAzureAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$reflection = new \ReflectionClass($this->adapter);
		$pathPrefixProperty = $reflection->getProperty('pathPrefix');
		$pathPrefixProperty->setAccessible(true);

		// Plugin could modify prefix
		$this->assertSame('modifiedPrefix/', $pathPrefixProperty->getValue($this->adapter));

		$containerProperty = $reflection->getProperty('container');
		$containerProperty->setAccessible(true);

		// Plugin could modify prefix
		$this->assertSame('modified-container', $containerProperty->getValue($this->adapter));
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
	 * @param   Azure   $adapter      Adapter being instatiated
	 * @param   IBlob   $azureClient  Client to connect.
	 * @param   string  $container    Name of the container
	 * @param   string  $prefix       Optional prefix.
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadAzureAdapter(Azure $adapter, IBlob $azureClient, &$container, &$prefix = null)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$prefix = 'modifiedPrefix';
		$container = 'modified-container';
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
	 * @param   Azure   $adapter      Adapter being instatiated
	 * @param   IBlob   $azureClient  Client to connect.
	 * @param   string  $container    Name of the container
	 * @param   string  $prefix       Optional prefix.
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadAzureAdapter(Azure $adapter, IBlob $azureClient, $container, $prefix = null)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}
}
