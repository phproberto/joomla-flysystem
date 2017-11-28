<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit\Adapter\Traits\Stubs;

defined('_JEXEC') || die;

use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Adapter\Traits\HasParameters;

/**
 * Adapter using HasParameters trait for testing purposes.
 *
 * @since   __DEPLOY_VERSION__
 */
abstract class AdapterWithParameters implements AdapterInterface
{
	use HasParameters;

	/**
	 * Default parameters
	 *
	 * @var  array
	 */
	public $defaults = [
		'default'     => 'parameter',
		'defaul-toow' => 'parameter'
	];

	/**
	 * Default configuration to ensure that correct data is sent to parent class.
	 *
	 * @return  array
	 */
	protected function defaults() : array
	{
		return $this->defaults;
	}
}
