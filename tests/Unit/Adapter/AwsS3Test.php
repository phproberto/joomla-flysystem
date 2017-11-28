<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit\Adapter;

use Aws\S3\S3Client;
use Joomla\CMS\Factory;
use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Adapter\AwsS3;
use Phproberto\Joomla\Flysystem\Tests\Unit\TestWithEvents;

/**
 * AwsS3 adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class AwsS3Test extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  AwsS3Adapter
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
		Factory::$application->registerEvent('onFlysystemBeforeLoadAwsS3Adapter', [$this, 'onFlysystemBeforeLoadAwsS3Adapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAwsS3Adapter', [$this, 'onFlysystemAfterLoadAwsS3Adapter']);


		$client = S3Client::factory($this->testServerConfig);
		$this->adapter = new AwsS3($client, 'your-bucket-name');
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
			'onFlysystemBeforeLoadAwsS3Adapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadAwsS3Adapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadAwsS3Adapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadAwsS3Adapter'));

		$this->assertSame('onFlysystemBeforeLoadAwsS3Adapter', $this->adapter->param('modifiedConfig'));
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

		$adapter->setParam(__FUNCTION__, true);
	}

	/**
	 * Triggered before adapter has been loaded.
	 *
	 * @param   AwsS3     $adapter  Adapter being instatiated
	 * @param   S3Client  $client   Client to connect to s3
	 * @param   string    $bucket   Bucket name
	 * @param   string    $prefix   Optional prefix.
	 * @param   array     $options  Additional options.
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadAwsS3Adapter(AwsS3 $adapter, S3Client $client, $bucket, $prefix, array &$options)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$options['modifiedConfig'] = __FUNCTION__;
		$adapter->setParam(__FUNCTION__, true);
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

		$adapter->setParam(__FUNCTION__, true);
	}

	/**
	 * Triggered after adapter has been loaded.
	 *
	 * @param   AwsS3     $adapter  Adapter being instatiated
	 * @param   S3Client  $client   Client to connect to s3
	 * @param   string    $bucket   Bucket name
	 * @param   string    $prefix   Optional prefix.
	 * @param   array     $options  Additional options.
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadAwsS3Adapter(AwsS3 $adapter, S3Client $client, $bucket, $prefix, array $options)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$adapter->setParam(__FUNCTION__, true);
	}
}
