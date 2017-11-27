<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use League\Flysystem\Adapter\Ftp as BaseFtpAdapter;
use Phproberto\Joomla\Flysystem\Adapter\Traits\HasParameters;

defined('_JEXEC') || die;

/**
 * FTP adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class Ftp extends BaseFtpAdapter
{
	use HasEvents, HasParameters;

	/**
	 * Constructor.
	 *
	 * @param   array  $config  Configuration
	 */
	public function __construct(array $config)
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadFtpAdapter', [&$config]);

		$this->updateParams($config);

		parent::__construct($this->params()->toArray());

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadFtpAdapter', [$config]);
	}
}
