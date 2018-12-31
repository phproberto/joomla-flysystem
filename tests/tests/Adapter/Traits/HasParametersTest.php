<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Adapter\Traits;

use ReflectionClass;
use Joomla\Registry\Registry;
use Phproberto\Joomla\Flysystem\Tests\Adapter\Traits\Stubs\AdapterWithParameters;

/**
 * HasParameters tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class HasParametersTest extends \TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->adapter = $this->getMockForAbstractClass(AdapterWithParameters::class);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function hasParamsReturnsCorrectValue()
	{
		$this->assertFalse($this->adapter->hasParams());

		$reflection = new ReflectionClass($this->adapter);
		$paramsProperty = $reflection->getProperty('params');
		$paramsProperty->setAccessible(true);

		$paramsProperty->setValue($this->adapter, new Registry(['foo' => 'bar']));

		$this->assertTrue($this->adapter->hasParams());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function initParamsLoadsDefaults()
	{
		$reflection = new ReflectionClass($this->adapter);
		$paramsProperty = $reflection->getProperty('params');
		$paramsProperty->setAccessible(true);

		$this->assertNull($paramsProperty->getValue($this->adapter));

		$this->adapter->initParams();

		$this->assertSame($this->adapter->defaults, $paramsProperty->getValue($this->adapter)->toArray());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function paramReturnsExistingValue()
	{
		foreach ($this->adapter->defaults as $key => $value)
		{
			$this->assertSame($value, $this->adapter->param($key));
		}
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function paramReturnsDefaultForNonExistingValue()
	{
		$this->assertSame('defaultValue', $this->adapter->param('nonExistingParam', 'defaultValue'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function paramsReturnsRegistry()
	{
		$this->assertInstanceOf(Registry::class, $this->adapter->params());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function paramsReturnsParamsProperty()
	{
		$reflection = new ReflectionClass($this->adapter);
		$paramsProperty = $reflection->getProperty('params');
		$paramsProperty->setAccessible(true);

		$customParams = new Registry(['custom' => 'params']);

		$paramsProperty->setValue($this->adapter, $customParams);

		$this->assertSame($customParams, $this->adapter->params());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function setParamSetsParameter()
	{
		$this->adapter->setParam('setParamTest', 'myValue');

		$this->assertSame('myValue', $this->adapter->param('setParamTest'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function setParamsSetsTheCorrectParams()
	{
		$params = ['foo' => 'bar'];

		$this->adapter->setParams($params);

		$expected = array_merge($this->adapter->defaults, $params);

		$this->assertSame($expected, $this->adapter->params()->toArray());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function updateParamsDoesNotOverwriteExistingParams()
	{
		$reflection = new ReflectionClass($this->adapter);
		$paramsProperty = $reflection->getProperty('params');
		$paramsProperty->setAccessible(true);

		$customParams = new Registry(['custom' => 'param']);

		$paramsProperty->setValue($this->adapter, $customParams);

		$this->adapter->updateParams(['updateTest' => 'myValue']);

		$this->assertSame('param', $this->adapter->param('custom'));
		$this->assertSame('myValue', $this->adapter->param('updateTest'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function updateParamsInitsParams()
	{
		$this->adapter->updateParams(['updateTest2' => 'myValue']);

		foreach ($this->adapter->defaults as $key => $value)
		{
			$this->assertSame($value, $this->adapter->param($key));
		}

		$this->assertSame('myValue', $this->adapter->param('updateTest2'));
	}
}
