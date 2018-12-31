<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Adapter;

use Joomla\CMS\Factory;
use Spatie\Dropbox\Client;
use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Adapter\Dropbox;
use Phproberto\Joomla\Flysystem\Tests\TestWithEvents;

/**
 * Dropbox adapter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class DropboxTest extends TestWithEvents
{
	/**
	 * Tested adapter.
	 *
	 * @var  Dropbox
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
		Factory::$application->registerEvent('onFlysystemBeforeLoadDropboxAdapter', [$this, 'onFlysystemBeforeLoadDropboxAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadAdapter', [$this, 'onFlysystemAfterLoadAdapter']);
		Factory::$application->registerEvent('onFlysystemAfterLoadDropboxAdapter', [$this, 'onFlysystemAfterLoadDropboxAdapter']);

		$this->adapter = new Dropbox(new Client('my-token'));
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
			'onFlysystemBeforeLoadDropboxAdapter',
			'onFlysystemAfterLoadAdapter',
			'onFlysystemAfterLoadDropboxAdapter'
		];

		$this->assertSame($expectedTriggeredEvents, array_keys($this->calledEvents));

		$reflection = new \ReflectionClass($this->adapter);
		$pathPrefixProperty = $reflection->getProperty('pathPrefix');
		$pathPrefixProperty->setAccessible(true);

		$this->assertSame('modifiedPrefix/', $pathPrefixProperty->getValue($this->adapter));
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
	 * @param   Dropbox  $adapter  Adapter being instatiated
	 * @param   Client   $client   Client to connect to Dropbox
	 * @param   string   $prefix   Optional prefix.
	 *
	 * @return  void
	 */
	public function onFlysystemBeforeLoadDropboxAdapter(Dropbox $adapter, Client $client, string &$prefix)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();

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
	 * @param   Dropbox  $adapter  Adapter being instatiated
	 * @param   Client   $client   Client to connect to Dropbox
	 * @param   string   $prefix   Optional prefix.
	 *
	 * @return  void
	 */
	public function onFlysystemAfterLoadDropboxAdapter(Dropbox $adapter, Client $client, string $prefix)
	{
		$this->calledEvents[__FUNCTION__] = func_get_args();
	}
}
