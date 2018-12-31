<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Library
 *
 * @copyright  Copyright (C) 2018 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem;

use InvalidArgumentException;
use League\Flysystem\FilesystemNotFoundException;
use Phproberto\Joomla\Flysystem\MountManager;

/**
 * File server.
 *
 * @since   __DEPLOY_VERSION__
 */
final class FileServer
{
	/**
	 * Prefix of the JoomlaFolder adapter.
	 *
	 * @const
	 */
	const JOOMLA_ADAPTER_PREFIX = 'joomla';

	/**
	 * Renderer instance.
	 *
	 * @var  $this
	 */
	private static $instance;

	/**
	 * Flysystem mount manager.
	 *
	 * @var  MountManager
	 */
	private $manager;

	/**
	 * Constructor.
	 *
	 * @throws \InvalidArgumentException
	 */
	private function __construct()
	{
		$this->manager = new MountManager;
	}

	/**
	 * Call forwarder.
	 *
	 * @param   string  $method     Called method
	 * @param   array   $arguments  Received arguments
	 *
	 * @throws InvalidArgumentException
	 * @throws FilesystemNotFoundException
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		$arguments = $this->filterPrefix($arguments);

		return call_user_func_array([$this->manager, $method], $arguments);
	}

	/**
	 * Clear the cached instance.
	 *
	 * @return  void
	 */
	public static function clear()
	{
		self::$instance = null;
	}

	/**
	 * Parse path into prefix and path.
	 *
	 * @param   string  $path  File path
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @return  string[] [:prefix, :path]
	 */
	protected function explodePrefixAndPath($path)
	{
		if (strpos($path, '://') < 1)
		{
			throw new InvalidArgumentException('No prefix detected in path: ' . $path);
		}

		return explode('://', $path, 2);
	}

	/**
	 * Retrieve the prefix from an arguments array.
	 *
	 * @param   array  $arguments  Arguments sent to a manager method
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @return  array
	 */
	private function filterPrefix(array $arguments)
	{
		if (empty($arguments))
		{
			throw new InvalidArgumentException('At least one argument needed');
		}

		$path = array_shift($arguments);

		if (!is_string($path))
		{
			throw new InvalidArgumentException('First argument should be a string');
		}

		array_unshift($arguments, $this->translatePath($path));

		return $arguments;
	}

	/**
	 * Get the cached instance
	 *
	 * @return  static
	 */
	public static function instance() : FileServer
	{
		if (null === self::$instance)
		{
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Core file systems
	 *
	 * @return  array
	 */
	private function redirectedPrefixes() : array
	{
		return [
			'admin'    => [self::JOOMLA_ADAPTER_PREFIX, 'administrator'],
			'image'    => [self::JOOMLA_ADAPTER_PREFIX, 'images'],
			'layout'   => [self::JOOMLA_ADAPTER_PREFIX, 'layouts'],
			'library'  => [self::JOOMLA_ADAPTER_PREFIX, 'libraries'],
			'media'    => [self::JOOMLA_ADAPTER_PREFIX, 'media'],
			'module'   => [self::JOOMLA_ADAPTER_PREFIX, 'modules'],
			'plugin'   => [self::JOOMLA_ADAPTER_PREFIX, 'plugins'],
			'site'     => [self::JOOMLA_ADAPTER_PREFIX, ''],
			'template' => [self::JOOMLA_ADAPTER_PREFIX, 'templates']
		];
	}

	/**
	 * Retrieve the translated prefix and path from redirections.
	 *
	 * @param   string  $receivedPath  Path
	 *
	 * @return  array
	 */
	private function translatePath($receivedPath)
	{
		list($prefix, $path) = $this->explodePrefixAndPath($receivedPath);

		$redirectedPrefixes = $this->redirectedPrefixes();

		if (!isset($redirectedPrefixes[$prefix]))
		{
			return $receivedPath;
		}

		list($destPrefix, $prePath) = $redirectedPrefixes[$prefix];

		if (isset($prePath))
		{
			$path = implode('/', [$prePath, $path]);
		}

		return implode('://', [$destPrefix, $path]);
	}
}
