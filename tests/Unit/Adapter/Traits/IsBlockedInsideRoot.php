<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Tests.Unit.Adapter.Traits
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Tests\Unit\Adapter\Traits;

defined('_JEXEC') || die;

use LogicException;

/**
 * Trait easily add tests that prevent access outside root folder.
 *
 * @since   __DEPLOY_VERSION__
 */
trait IsBlockedInsideRoot
{
	/**
	 * @test
	 *
	 * @param   string  $path  Insecure path to test
	 *
	 * @return  void
	 *
	 * @dataProvider insecurePaths
	 *
	 * @expectedException  LogicException
	 */
	public function throwsExceptionOnInsecurePaths($path)
	{
		$this->adapter->has($path);
	}

	/**
	 * Provider of insecure paths to test.
	 *
	 * @return  array
	 */
	public function insecurePaths()
	{
		return [
			['../index.php'],
			['./../index.php'],
			['./jui/../../index.php'],
			['..']
		];
	}
}
