<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Library
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem;

use Joomla\CMS\Factory;
use Phproberto\Joomla\Flysystem\JoomlaFilesystem;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use Phproberto\Joomla\Flysystem\Adapter\BlockedLocal;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;
use League\Flysystem\MountManager as BaseMountManager;

/**
 * Mount manager.
 *
 * @since   __DEPLOY_VERSION__
 */
final class MountManager extends BaseMountManager
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   array  $filesystems  Filesystems to load
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function __construct(array $filesystems = [])
	{
		$filesystems = array_merge($filesystems, $this->coreFileSystems());

		$this->trigger('onFlysystemBeforeLoadMountManager', [&$filesystems]);

		parent::__construct($filesystems);

		$this->trigger('onFlysystemAfterLoadMountManager', [$filesystems]);
	}

	/**
	 * Core file systems
	 *
	 * @return  array
	 */
	private function coreFileSystems() : array
	{
		return [
			'cache'  => new Filesystem(new BlockedLocal(Factory::getConfig()->get('cache_path', JPATH_CACHE))),
			'log'    => new Filesystem(new BlockedLocal(Factory::getConfig()->get('log_path'))),
			'joomla' => new Filesystem(new JoomlaFolder),
			'tmp'    => new Filesystem(new BlockedLocal(Factory::getConfig()->get('tmp_path')))
		];
	}
}
