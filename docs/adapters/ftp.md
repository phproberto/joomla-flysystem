## Ftp Adapter

Wrapper for [Flysystem FTP Adapter](https://github.com/thephpleague/flysystem/blob/master/src/Adapter/Ftp.php) with Joomla events support.

1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadFtpAdapter](#onFlysystemBeforeLoadFtpAdapter)
        * [onFlysystemAfterLoadFtpAdapter](#onFlysystemAfterLoadFtpAdapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use:  

```php
JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\Ftp as Adapter;

$filesystem = new Filesystem(new Adapter([
    'host' => 'ftp.example.com',
    'username' => 'username',
    'password' => 'password',

    /** optional config settings */
    'port' => 21,
    'root' => '/path/to/root',
    'passive' => true,
    'ssl' => true,
    'timeout' => 30,
]));
```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadFtpAdapter** Called before an FTP adapter instance has been created.<a id="onFlysystemBeforeLoadFtpAdapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   Ftp    $adapter  Adapter being instatiated
 * @param   array  $config   Adapter configuration
 *
 * @return  void
 */
public function onFlysystemBeforeLoadFtpAdapter(Ftp $adapter, array &$config)
```

**onFlysystemAfterLoadFtpAdapter** Called after an FTP adapter instance has been created.<a id="onFlysystemAfterLoadFtpAdapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   Ftp    $adapter  Adapter being instatiated
 * @param   array  $config   Adapter configuration
 *
 * @return  void
 */
public function onFlysystemAfterLoadFtpAdapter(Ftp $adapter, array $config)
```