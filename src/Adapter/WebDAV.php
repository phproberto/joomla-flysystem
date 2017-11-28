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

use Sabre\DAV\Client;
use League\Flysystem\WebDAV\WebDAVAdapter;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;

/**
 * WebDAV adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class WebDAV extends WebDAVAdapter
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   Client  $client           WebDAV client
	 * @param   string  $prefix           Optional prefix
	 * @param   bool    $useStreamedCopy  Use streamd copy. defaults to true.
	 */
	public function __construct(Client $client, $prefix = null, $useStreamedCopy = true)
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadWebDAVAdapter', [$client, &$prefix, &$useStreamedCopy]);

		parent::__construct($client, $prefix, $useStreamedCopy);

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadWebDAVAdapter', [$client, $prefix, $useStreamedCopy]);
	}
}
