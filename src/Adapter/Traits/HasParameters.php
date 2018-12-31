<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter.Traits
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
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
	 * Check if this adapter has params.
	 *
	 * @return  boolean
	 */
	public function hasParams()
	{
		return null !== $this->params;
	}

	/**
	 * Init parameters.
	 *
	 * @return  self
	 */
	public function initParams() : AdapterInterface
	{
		$this->params = new Registry($this->defaults());

		return $this;
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
	 * Retrieve the adapter parameters.
	 *
	 * @return  Registry
	 */
	public function params() : Registry
	{
		if (!$this->hasParams())
		{
			$this->initParams();
		}

		return $this->params;
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
		if (!$this->hasParams())
		{
			$this->initParams();
		}

		$this->params->set($name, $value);

		return $this;
	}

	/**
	 * Set the adapter parameters. Overwrites previously existing parameter.
	 *
	 * @param   array  $params  Parameters to set.
	 *
	 * @return  self
	 */
	public function setParams(array $params) : AdapterInterface
	{
		$this->initParams();
		$this->updateParams($params);

		return $this;
	}

	/**
	 * Update parameters (without delete previous parameters).
	 *
	 * @param   array  $params  Parameters to set.
	 *
	 * @return  self
	 */
	public function updateParams(array $params) : AdapterInterface
	{
		if (!$this->hasParams())
		{
			$this->initParams();
		}

		$this->params = new Registry(array_merge($this->params->toArray(), $params));

		return $this;
	}
}
