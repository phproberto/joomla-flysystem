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

use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use ZipArchive;

/**
 * Zip archive adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class ZipFile extends ZipArchiveAdapter
{
	use HasEvents;

	/**
	 * Constructor.
	 *
	 * @param   string      $location  Path to the zip file
	 * @param   ZipArchive  $file      Source file.
	 * @param   string      $prefix    Optional prefix
	 */
	public function __construct($location, ZipArchive $file = null, $prefix = null)
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadZipFileAdapter', [&$location, $file, &$prefix]);

		parent::__construct($location, $file, $prefix);

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadZipFileAdapter', [$location, $file, $prefix]);
	}
}
