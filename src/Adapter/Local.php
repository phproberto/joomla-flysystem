<?php
/**
 * @package     Phproberto\Joomla\Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

use Joomla\Registry\Registry;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use League\Flysystem\Adapter\Local as LocalAdapter;

/**
 * Joomla local file adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
final class Local extends LocalAdapter
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   string          $path    Relative Joomla path
	 * @param   array           $config  Optional configuration
	 * @param   CMSApplication  $app     Application where adapter is executed
	 *
	 * @throws  LogicException
	 */
	public function __construct(string $path = null, array $config = [], CMSApplication $app = null)
	{
		$this->app = $app;
		$this->setConfig($config);

		$path = JPATH_SITE . ($path ? '/' . $path : null);

		$this->trigger('onFlysystemBeforeLoadAdapter', [&$path, $this->application()]);

		parent::__construct(
			$path,
			$this->config->get('writeFlags'),
			$this->config->get('linkHandling'),
			$this->config->get('permissions')
		);

		$this->trigger('onFlysystemAfterLoadAdapter', [$path, $this->application()]);
	}

	/**
	 * Retrieve the adapter config.
	 *
	 * @return  Registry
	 */
	public function config() : Registry
	{
		return $this->config;
	}

	/**
	 * Default configuration to ensure that correct data is sent to parent class.
	 *
	 * @return  array
	 */
	private function defaults() : array
	{
		return [
			'writeFlags'   => LOCK_EX,
			'linkHandling' => static::DISALLOW_LINKS,
			'permissions'  => []
		];
	}

	/**
	 * Set the adapter configuration.
	 *
	 * @param   array  $config  Received configuration
	 *
	 * @return  Local
	 */
	public function setConfig(array $config) : Local
	{
		$this->config = new Registry(array_merge($this->defaults(), $config));

		return $this;
	}
}
