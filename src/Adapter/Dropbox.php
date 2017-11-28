<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

defined('_JEXEC') || die;

use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;

/**
 * Dropbox adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class Dropbox extends DropboxAdapter
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   Client  $client   Client to connect to dropbox
	 * @param   string  $prefix   Optional prefix.
	 */
	public function __construct(Client $client, string $prefix = '')
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadDropboxAdapter', [$client, &$prefix]);

		parent::__construct($client, $prefix);

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadDropboxAdapter', [$client, $prefix]);
	}
}

