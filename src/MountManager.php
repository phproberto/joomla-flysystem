<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Library
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem;

use Joomla\CMS\Factory;
use League\Flysystem\MountManager as BaseMountManager;
use League\Flysystem\Adapter\Local as PureLocal;
use Joomla\CMS\Application\CMSApplication;
use Phproberto\Joomla\Flysystem\Adapter\Local;
use Phproberto\Joomla\Flysystem\JoomlaFilesystem;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;

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
	 * @param   array           $filesystems  Filesystems to load
	 * @param   CMSApplication  $app          Application loading the mount manager
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function __construct(array $filesystems = [], CMSApplication $app = null)
	{
		$this->app = $app;

		$filesystems = array_merge($filesystems, $this->coreFileSystems());

		$this->trigger('onFlysystemBeforeLoadFileManager', [&$filesystems, $this->application()]);

		parent::__construct($filesystems);

		$this->trigger('onFlysystemAfterLoadFileManager', [$filesystems, $this->application()]);
	}

	/**
	 * Core file systems
	 *
	 * @return  array
	 */
	private function coreFileSystems() : array
	{
		return [
			'cache'  => new Filesystem(new PureLocal(Factory::getConfig()->get('cache_path', JPATH_CACHE))),
			'log'    => new Filesystem(new PureLocal(Factory::getConfig()->get('log_path'))),
			'joomla' => new Filesystem(new Local),
			'tmp'    => new Filesystem(new PureLocal(Factory::getConfig()->get('tmp_path')))
		];
	}
}
