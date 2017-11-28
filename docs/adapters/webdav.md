## WebDAV Adapter

Wrapper for [Flysystem WebDAV adapter](https://github.com/thephpleague/flysystem-webdav) with Joomla events support.

1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadWebDAVAdapter](#onFlysystemBeforeLoadWebDAVAdapter)
        * [onFlysystemAfterLoadWebDAVAdapter](#onFlysystemAfterLoadWebDAVAdapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use:  

```php
JLoader::import('flysystem.library');

use Sabre\DAV\Client;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\WebDAV;

$settings = ['baseUri' => 'http://localhost'];

$client = new Client($settings);

$adapter = new WebDAV($client, 'optional/path/prefix');

$flysystem = new Flysystem\Filesystem($adapter);

```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadWebDAVAdapter** Called before a WebDAV adapter instance has been created.<a id="onFlysystemBeforeLoadWebDAVAdapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   WebDAV  $adapter          Adapter being instatiated
 * @param   Client  $client           WebDAV client
 * @param   string  $prefix           Optional prefix
 * @param   bool    $useStreamedCopy  Use streamd copy. defaults to true.
 *
 * @return  void
 */
public function onFlysystemBeforeLoadWebDAVAdapter(WebDAV $adapter, Client $client, &$prefix = null, &$useStreamedCopy = true)
```

**onFlysystemAfterLoadWebDAVAdapter** Called after a WebDAV adapter instance has been created.<a id="onFlysystemAfterLoadWebDAVAdapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   WebDAV  $adapter          Adapter being instatiated
 * @param   Client  $client           WebDAV client
 * @param   string  $prefix           Optional prefix
 * @param   bool    $useStreamedCopy  Use streamd copy. defaults to true.
 *
 * @return  void
 */
public function onFlysystemAfterLoadWebDAVAdapter(WebDAV $adapter, Client $client, $prefix = null, $useStreamedCopy = true)
```