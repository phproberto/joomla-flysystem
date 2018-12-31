<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

defined('_JEXEC') || die;

use League\Flysystem\Azure\AzureAdapter;
use MicrosoftAzure\Storage\Blob\Internal\IBlob;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;

/**
 * Azure adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class Azure extends AzureAdapter
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   IBlob   $azureClient  Client to connect.
	 * @param   string  $container    Name of the container
	 * @param   string  $prefix       Optional prefix.
	 */
	public function __construct(IBlob $azureClient, $container, $prefix = null)
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadAzureAdapter', [$azureClient, &$container, &$prefix]);

		parent::__construct($azureClient, $container, $prefix);

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadAzureAdapter', [$azureClient, $container, $prefix]);
	}
}
