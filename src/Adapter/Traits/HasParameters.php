<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter.Traits
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter\Traits;

defined('_JEXEC') || die;

use Joomla\Registry\Registry;
use League\Flysystem\AdapterInterface;

/**
 * Trait for adapters with parameters.
 *
 * @since   __DEPLOY_VERSION__
 */
trait HasParameters
{
	/**
	 * Stored parameters.
	 *
	 * @var  Registry
	 */
	protected $params;

	/**
	 * Default configuration to ensure that correct data is sent to parent class.
	 *
	 * @return  array
	 */
	protected function defaults() : array
	{
		return [];
	}

	/**
	 * Retrieve the adapter params.
	 *
	 * @return  Registry
	 */
	public function params() : Registry
	{
		return $this->params;
	}

	/**
	 * Get a param value.
	 *
	 * @param   string  $name     Parameter name
	 * @param   mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed
	 */
	public function param($name, $default = null)
	{
		return $this->params()->get($name, $default);
	}

	/**
	 * Set the adapter configuration.
	 *
	 * @param   array  $params  Received configuration
	 *
	 * @return  self
	 */
	public function setParams(array $params) : AdapterInterface
	{
		$this->params = new Registry(array_merge($this->defaults(), $params));

		return $this;
	}

	/**
	 * Set the value of a parameter.
	 *
	 * @param   string  $name   Parameter name
	 * @param   mixed   $value  Value to assign to selected parameter
	 *
	 * @return  self
	 */
	public function setParam($name, $value) : AdapterInterface
	{
		$this->params->set($name, $value);

		return $this;
	}
}
