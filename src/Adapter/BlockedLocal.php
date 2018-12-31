<?php
/**
 * @package     Phproberto\Joomla\Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

use League\Flysystem\Adapter\Local;
use Phproberto\Joomla\Flysystem\Adapter\Traits\IsBlockedInsideRoot;

/**
 * Local adapter that prevents access to files outside root folder.
 *
 * @since   __DEPLOY_VERSION__
 */
class BlockedLocal extends Local
{
	use IsBlockedInsideRoot;
}
