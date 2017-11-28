<?php
/**
 * @package     Phproberto.Joomla-Flysystem
 * @subpackage  Adapter
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Flysystem\Adapter;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Phproberto\Joomla\Flysystem\Traits\HasEvents;
use Phproberto\Joomla\Flysystem\Adapter\Traits\HasParameters;

defined('_JEXEC') || die;

/**
 * AwsS3 adapter.
 *
 * @since   __DEPLOY_VERSION__
 */
class AwsS3 extends AwsS3Adapter
{
	use HasEvents, HasParameters;

	/**
	 * Constructor.
	 *
	 * @param   S3Client  $client   Client to connect to s3
	 * @param   string    $bucket   Bucket name
	 * @param   string    $prefix   Optional prefix.
	 * @param   array     $options  Additional options.
	 */
	public function __construct(S3Client $client, $bucket, $prefix = '', array $options = [])
	{
		$this->trigger('onFlysystemBeforeLoadAdapter');
		$this->trigger('onFlysystemBeforeLoadAwsS3Adapter', [$client, $bucket, $prefix, &$options]);

		$this->updateParams($options);

		parent::__construct($client, $bucket, $prefix, $this->params()->toArray());

		$this->trigger('onFlysystemAfterLoadAdapter');
		$this->trigger('onFlysystemAfterLoadAwsS3Adapter', [$client, $bucket, $prefix, $options]);
	}
}
