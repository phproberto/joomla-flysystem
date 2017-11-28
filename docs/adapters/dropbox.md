## Dropbox Adapter

Wrapper for [Spatie Dropbox v2 adapter](https://github.com/spatie/flysystem-dropbox) with Joomla events support. 

1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadDropboxAdapter](#onFlysystemBeforeLoadDropboxAdapter)
        * [onFlysystemAfterLoadDropboxAdapter](#onFlysystemAfterLoadDropboxAdapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use:  

```php
JLoader::import('flysystem.library');

use Spatie\Dropbox\Client;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\Dropbox;

$client = new Client($authorizationToken);

$adapter = new Dropbox($client);

$filesystem = new Filesystem($adapter);
```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadDropboxAdapter** Called before a Dropbox adapter instance has been created.<a id="onFlysystemBeforeLoadDropboxAdapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   Dropbox  $adapter  Adapter being instatiated
 * @param   Client   $client   Client to connect to Dropbox
 * @param   string   $prefix   Optional prefix.
 *
 * @return  void
 */
public function onFlysystemBeforeLoadDropboxAdapter(Dropbox $adapter, Client $client, string &$prefix)
```

**onFlysystemAfterLoadDropboxAdapter** Called after a Dropbox adapter instance has been created.<a id="onFlysystemAfterLoadDropboxAdapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   Dropbox  $adapter  Adapter being instatiated
 * @param   Client   $client   Client to connect to Dropbox
 * @param   string   $prefix   Optional prefix.
 *
 * @return  void
 */
public function onFlysystemAfterLoadDropboxAdapter(Dropbox $adapter, Client $client, string $prefix)
```