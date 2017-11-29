<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter.Traits
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter\Traits;

defined('_JEXEC') || die;

use League\Flysystem\Util;

/**
 * Trait for adapters that prevent access outside root folder.
 *
 * @since   __DEPLOY_VERSION__
 */
trait IsBlockedInsideRoot
{
	/**
	 * Prefix a path. Overriden to ensure that access outside root folder is forbidden.
	 *
	 * @param   string  $path  Path to apply prefix.
	 *
	 * @return  string  Prefixed path
	 *
	 * @throws  LogicException
	 */
	public function applyPathPrefix($path)
	{
		$path = Util::normalizeRelativePath($path);

		return parent::applyPathPrefix($path);
	}
}
