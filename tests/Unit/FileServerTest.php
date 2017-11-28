<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit;

use Joomla\CMS\Factory;
use Phproberto\Joomla\Flysystem\FileServer;
use InvalidArgumentException;

/**
 * FileServer tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class FileServerTest extends \TestCaseDatabase
{
	/**
	 * FileServer instance.
	 *
	 * @var  FileServer
	 */
	private $fileServer;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->saveFactoryState();

		Factory::$session     = $this->getMockSession();
		Factory::$config      = $this->getMockConfig();
		Factory::$config = new \JObject(
			[
				'cache_path' => __DIR__ . '/Stubs/cache',
				'log_path'   => __DIR__ . '/Stubs/logs',
				'tmp_path'   => __DIR__ . '/Stubs/tmp'
			]
		);
		Factory::$application = $this->getMockCmsApp();

		$this->fileServer = FileServer::instance();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return  void
	 */
	protected function tearDown()
	{
		$this->restoreFactoryState();

		parent::tearDown();
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorIsPrivate()
	{
		$reflection = new \ReflectionClass($this->fileServer);
		$constructor = $reflection->getConstructor();

		$this->assertTrue($constructor->isPrivate());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function canReadFiles()
	{
		// Default MountManager stuff
		$this->assertTrue($this->fileServer->has('cache://testCache.txt'));
		$this->assertTrue($this->fileServer->has('joomla://htaccess.txt'));
		$this->assertTrue($this->fileServer->has('log://testLog.txt'));
		$this->assertTrue($this->fileServer->has('tmp://testTmp.txt'));

		// Redirected stuff
		$this->assertTrue($this->fileServer->has('admin://manifests/libraries/joomla.xml'));
		$this->assertTrue($this->fileServer->has('image://joomla_black.png'));
		$this->assertTrue($this->fileServer->has('layout://joomla/system/message.php'));
		$this->assertTrue($this->fileServer->has('library://joomla/filesystem/file.php'));
		$this->assertTrue($this->fileServer->has('media://jui/css/bootstrap.css'));
		$this->assertTrue($this->fileServer->has('module://mod_menu/mod_menu.xml'));
		$this->assertTrue($this->fileServer->has('plugin://content/vote/vote.xml'));
		$this->assertTrue($this->fileServer->has('site://htaccess.txt'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function clearRemovesCachedInstance()
	{
		$reflection = new \ReflectionClass($this->fileServer);

		$instanceProperty = $reflection->getProperty('instance');
		$instanceProperty->setAccessible(true);

		$this->assertInstanceOf(FileServer::class, $instanceProperty->getValue($this->fileServer));

		FileServer::clear();

		$this->assertSame(null, $instanceProperty->getValue($this->fileServer));
	}

	/**
	 * instance returns cached instance.
	 *
	 * @return  void
	 */
	public function testInstanceReturnsCachedInstance()
	{
		$reflection = new \ReflectionClass($this->fileServer);

		$managerProperty = $reflection->getProperty('manager');
		$managerProperty->setAccessible(true);
		$managerProperty->setValue($this->fileServer, 'foo');

		$newInstance = FileServer::instance();

		$this->assertSame('foo', $managerProperty->getValue($newInstance));
	}

	/**
	 * @test
	 *
	 * @return void
	 *
	 * @expectedException  InvalidArgumentException
	 */
	public function throwsExceptionOnMissingPath()
	{
		$this->fileServer->has();
	}

	/**
	 * @test
	 *
	 * @return void
	 *
	 * @expectedException  InvalidArgumentException
	 */
	public function throwsExceptionOnNonStringPath()
	{
		$this->fileServer->has(new \stdClass);
	}

	/**
	 * @test
	 *
	 * @return void
	 *
	 * @expectedException  InvalidArgumentException
	 */
	public function throwsExceptionOnWrongPathString()
	{
		$this->fileServer->has('wrong-path');
	}
}
