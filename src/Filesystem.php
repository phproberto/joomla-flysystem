<?php
/**
 * @package     Phproberto\Joomla\Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem;

use League\Flysystem\AdapterInterface;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use League\Flysystem\Filesystem as BaseFilesystem;

/**
 * Joomla file system.
 *
 * @since   __DEPLOY_VERSION__
 */
final class Filesystem extends BaseFilesystem
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   AdapterInterface  $adapter  Relative joomla path. Defaults to root folder.
	 * @param   array             $config   Optional configuration
	 */
	public function __construct(AdapterInterface $adapter, $config = null)
	{
		$this->trigger('onFlysystemBeforeLoadFilesystem', [&$adapter, &$config]);

		parent::__construct($adapter, $config);

		$this->trigger('onFlysystemAfterLoadFilesystem', [$adapter, $config]);
	}
}
