<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Adapter;

use Joomla\CMS\Factory;
use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Adapter\Ftp;
use Phproberto\Joomla\Flysystem\Tests\TestWithEvents;

/**
 * Ftp adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class FtpTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  Ftp
	 */
	private $adapter;

	/**
	 * Test server configuration.
	 *
	 * @var  array
	 */
	private $testServerConfig = [
		'host'     => 'speedtest.tele2.net',
		'username' => 'anonymous',
		'password' => 'anonymous'
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
		Factory::$application->registerEvent('onFlysystemBeforeLoadFtpAdapter', [$this, 'onFlysystemBeforeLoadFtpAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadFtpAdapter', [$this, 'onFlysystemAfterLoadFtpAdapter']);

		$this->adapter = new Ftp($this->testServerConfig);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorSetsConfig()
	{
		$reflection = new \ReflectionClass($this->adapter);
		$hostPrefixProperty = $reflection->getProperty('host');
		$hostPrefixProperty->setAccessible(true);

		$this->assertSame($this->testServerConfig['host'], $hostPrefixProperty->getValue($this->adapter));
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
			'onFlysystemBeforeLoadFtpAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadFtpAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemBeforeLoadFtpAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadAdapter'));
		$this->assertTrue($this->adapter->param('onFlysystemAfterLoadFtpAdapter'));

		$this->assertSame('onFlysystemBeforeLoadFtpAdapter', $this->adapter->param('modifiedConfig'));
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
	 * @param   Ftp    $adapter  Adapter being instatiated
	 * @param   array  $config   Adapter configuration
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadFtpAdapter(Ftp $adapter, array &$config)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$config['modifiedConfig'] = __FUNCTION__;
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
	 * @param   Ftp    $adapter  Adapter being instatiated
	 * @param   array  $config   Adapter configuration
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadFtpAdapter(Ftp $adapter, array $config)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

		$adapter->setParam(__FUNCTION__, true);
	}
}
