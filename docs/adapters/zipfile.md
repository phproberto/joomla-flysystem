## ZipFile adapter

Wrapper for [Flysystem Zip Adapter](https://github.com/thephpleague/flysystem-ziparchive) with Joomla events support.


1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadZipFileAdapter](#onFlysystemBeforeLoadZipFileAdapter)
        * [onFlysystemAfterLoadZipFileAdapter](#onFlysystemAfterLoadFtpAdapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use:  

```php
JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\ZipFile;

$filesystem = new Filesystem(new ZipFile(__DIR__.'/path/to/archive.zip'))
```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadZipFileAdapter** Called after a ZipFile adapter instance has been created.<a id="onFlysystemBeforeLoadZipFileAdapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   ZipFile     $adapter   Adapter being instatiated
 * @param   string      $location  Path to the zip file
 * @param   ZipArchive  $file      Source file.
 * @param   string      $prefix    Optional prefix
 *
 * @return  void
 */
public function onFlysystemBeforeLoadZipFileAdapter(ZipFile $adapter, &$location, ZipArchive $file = null, &$prefix = null)
```

**onFlysystemAfterLoadZipFileAdapter** Called after a ZipFile adapter instance has been created.<a id="onFlysystemAfterLoadZipFileAdapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   ZipFile     $adapter   Adapter being instatiated
 * @param   string      $location  Path to the zip file
 * @param   ZipArchive  $file      Source file.
 * @param   string      $prefix    Optional prefix
 *
 * @return  void
 */
public function onFlysystemAfterLoadZipFileAdapter(ZipFile $adapter, $location, ZipArchive $file = null, $prefix = null)
```