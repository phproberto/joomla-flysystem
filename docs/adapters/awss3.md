## AWS S3 v3

Wrapper for [Flysystem Adapter for AWS SDK V3](https://github.com/thephpleague/flysystem-aws-s3-v3) with Joomla events support. 

1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadAwsS3Adapter](#onFlysystemBeforeLoadAwsS3Adapter)
        * [onFlysystemAfterLoadAwsS3Adapter](#onFlysystemAfterLoadAwsS3Adapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use:  


```php
JLoader::import('flysystem.library');

use Aws\S3\S3Client;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\AwsS3;

$client = S3Client::factory([
    'credentials' => [
        'key'    => 'your-key',
        'secret' => 'your-secret',
    ],
    'region' => 'your-region',
    'version' => 'latest|version',
]);

$adapter = new AwsS3($client, 'your-bucket-name', 'optional/path/prefix');
$filesystem = new Filesystem($adapter);

```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadAwsS3Adapter** Called before an AwsS3 adapter instance is created. <a id="onFlysystemBeforeLoadAwsS3Adapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   AwsS3     $adapter  Adapter being instatiated
 * @param   S3Client  $client   Client to connect to s3
 * @param   string    $bucket   Bucket name
 * @param   string    $prefix   Optional prefix.
 * @param   array     $options  Additional options.
 *
 * @return  void
 */
public function onFlysystemBeforeLoadAwsS3Adapter(AwsS3 $adapter, S3Client $client, $bucket, $prefix, array &$options)
```

**onFlysystemAfterLoadAwsS3Adapter** Called after an AwsS3 adapter instance has been created. <a id="onFlysystemAfterLoadAwsS3Adapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   AwsS3     $adapter  Adapter being instatiated
 * @param   S3Client  $client   Client to connect to s3
 * @param   string    $bucket   Bucket name
 * @param   string    $prefix   Optional prefix.
 * @param   array     $options  Additional options.
 *
 * @return  void
 */
public function onFlysystemAfterLoadAwsS3Adapter(AwsS3 $adapter, S3Client $client, $bucket, $prefix, array $options)
```