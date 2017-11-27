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
use League\Flysystem\Adapter\Local;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use Phproberto\Joomla\Flysystem\Adapter\Traits\HasParameters;

/**
 * Joomla local file adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
final class JoomlaFolder extends Local
{
	use HasEvents, HasParameters;

	/**
	 * Constructor.
	 *
	 * @param   string  $path    Relative Joomla path
	 * @param   array   $config  Optional configuration
	 *
	 * @throws  LogicException
	 */
	public function __construct(string $path = null, array $config = [])
	{
		$path = JPATH_SITE . ($path ? '/' . $path : null);

		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadJoomlaFolderAdapter', [&$path, &$config]);

		$this->updateParams($config);

		parent::__construct(
			$path,
			$this->param('writeFlags'),
			$this->param('linkHandling'),
			$this->param('permissions')
		);

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadJoomlaFolderAdapter', [$path, $config]);
	}

	/**
	 * Default configuration to ensure that correct data is sent to parent class.
	 *
	 * @return  array
	 */
	protected function defaults() : array
	{
		return [
			'writeFlags'   => LOCK_EX,
			'linkHandling' => static::DISALLOW_LINKS,
			'permissions'  => []
		];
	}
}
