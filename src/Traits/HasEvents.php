<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Library
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Traits;

defined('_JEXEC') || die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

/**
 * Trait for class with events.
 *
 * @since   __DEPLOY_VERSION__
 */
trait HasEvents
{
	/**
	 * Plugins that have been already imported.
	 *
	 * @var  array
	 */
	private $importedPlugins = [];

	/**
	 * Import available plugins.
	 *
	 * @return  void
	 */
	private function importPlugins()
	{
		$importablePluginTypes = array_diff($this->importablePlugins(), $this->importedPlugins);

		foreach ($importablePluginTypes as $pluginType)
		{
			PluginHelper::importPlugin($pluginType);

			$this->importedPlugins[] = $pluginType;
		}
	}

	/**
	 * Retrieve list of importable plugins.
	 *
	 * @return  array
	 */
	private function importablePlugins() : array
	{
		return ['flysystem'];
	}

	/**
	 * Trigger an event on the attached instance.
	 *
	 * @param   string  $event   Event to trigger
	 * @param   array   $params  Params for the event triggered
	 *
	 * @return  array
	 */
	private function trigger(string $event, array $params = []) : array
	{
		$this->importPlugins();

		// Always send instance as first param
		array_unshift($params, $this);

		return (array) Factory::getApplication()->triggerEvent($event, $params);
	}
}
