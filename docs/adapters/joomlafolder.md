## JoomlaFolder Adapter

This is a custom adapter extends the [local flysystem adapter](https://github.com/thephpleague/flysystem/blob/master/src/Adapter/Local.php). The goal is to ease dealing with Joomla files providing some prefixes that allow paths that are easy to remember and allows files to be moved around without changing your PHP code. 


1. [Usage](#usage)
    * [Usage through FileServer](#fileserver)
    * [Custom usage](#custom-usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadJoomlaFolderAdapter](#onFlysystemBeforeLoadJoomlaFolderAdapter)
        * [onFlysystemAfterLoadJoomlaFolderAdapter](#onFlysystemAfterLoadJoomlaFolderAdapter)

### 1. Usage <a id="usage"></a>

This adapter is loaded by default by the `FileServer` class so you don't need to specifically load it if you use `FileServer`.

### Usage through FileServer <a id="fileserver"></a>
This adapter is loaded by default by the `FileServer` class so you don't need to specifically load it if you use `FileServer` like:  
```php
JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\FileServer;

$files = FileServer::instance();

// Admin file. Stored in administrator/manifests/libraries/joomla.xml
echo $files->read('admin://manifests/libraries/joomla.xml');

// Cache file. Stored in cache/error.php
echo $files->read('cache://error.php');

// Image file. Stored in /images/joomla_black.png
echo $files->read('image://joomla_black.png');

// Log file. Stored in /administrator/logs/error.php
echo $files->read('log://error.php');

// Layout file. Stored in /layouts/joomla/system/message.php
echo $files->read('layout://joomla/system/message.php');

// Library file. Stored in /libraries/joomla/filesystem/file.php
echo $files->read('library://joomla/filesystem/file.php');

// Media file. Stored in /media/jui/css/bootstrap.css
echo $files->read('media://jui/css/bootstrap.css');

// Module file. Stored in /modules/mod_menu/mod_menu.xml
echo $files->read('module://mod_menu/mod_menu.xml');

// Plugin file. Stored in /plugins/content/vote/vote.xml
echo $files->read('plugin://content/vote/vote.xml');

// Site file. Stored in /htaccess.txt
echo $files->read('site://htaccess.txt');

// Temp file. Stored in /tmp/index.html
echo $files->read('tmp://index.html');
```

### Custom usage <a id="custom-usage"></a>

Let's say that you want to provide an adapter that access files on a specific joomla folder. You can use relative paths like:  

```php
JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;

// This will use JPATH_SITE . /media/com_sample/images as source folder
$images = new Filesystem(new JoomlaFolder('media/com_sample/images'));

// Check if JPATH_SITE . /media/com_sample/images/sample-image.jpg exists
if ($images->has('sample-image.jpg'))
{
	echo "It exists!";
}

```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadJoomlaFolderAdapter** Called before an JoomlaFolder adapter instance has been created.<a id="onFlysystemBeforeLoadJoomlaFolderAdapter"></a>

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   JoomlaFolder   $adapter  Adapter being instatiated
 * @param   string         $path     Path being loaded
 * @param   string         $config   Configuration for the adapter
 *
 * @return  void
 */
public function onFlysystemBeforeLoadJoomlaFolderAdapter(JoomlaFolder $adapter, string &$path, array &$config)
```

**onFlysystemAfterLoadJoomlaFolderAdapter** Called after an JoomlaFolder adapter instance has been created.<a id="onFlysystemAfterLoadJoomlaFolderAdapter"></a>

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   JoomlaFolder  $adapter  Adapter being instatiated.
 * @param   string        $path     Path being loaded.
 * @param   string        $config   Configuration for the adapter.
 *
 * @return  void
 */
public function onFlysystemAfterLoadJoomlaFolderAdapter(JoomlaFolder $adapter, string $path, array $config)
```
