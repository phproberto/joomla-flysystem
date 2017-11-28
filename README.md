# Flysystem integration for Joomla!

> Integrate [Flysystem](http://flysystem.thephpleague.com/) with Joomla!

NOTE: This is a work in progress shared to get feedback.

## What is this?

This is a way to provide an extendable system to easily access, from Joomla, files stored anywhere (Dropbox, AWS, and any existing adapter that exists or that you want to create). 

### Benefits

* Manage externally stored files in an easy way as if they were stored locally.
* Access joomla files in an abstracted way that allows to move files around without breaking actual code.
* All the filesystems and mount managers have events before and after being loaded so it's highly customisable.
* You can add custom adapters through plugins.
* Provides a `FileServer` class to access all the existing file systems in a single and easy way.
* All the classes are still usable separately to provide maximum flexibility for devs.

### Supported adapters.

All the [official adapters](https://github.com/thephpleague/flysystem#adapters) are supported but this library provides specific wrappers for the most commonly used adapters. Using these specific adapters allows Joomla plugins to connect when an adapter or filesystem is loaded to allow customisations.

Available wrappers:

* [AWS S3 v3](./src/Adapter/AwsS3.php). Load files stored in AWS S3.
* [Azure](./src/Adapter/Azure.php). Load files stored in Azure.
* [Dropbox](./src/Adapter/Dropbox.php). Load files stored in Dropbox.
* [Ftp](./src/Adapter/Ftp.php). Load files stored in an FTP server.
* [JoomlaFolder](./src/Adapter/JoomlaFolder.php). Load files from the Joomla site.
* [WebDAV](./src/Adapter/WebDAB.php). Load WebDAV files.
* [ZipFile](./src/Adapter/ZipFile.php). Load & store files from zip files. Requires `php-zip` extension installed.

For common stuff you can do with Flysystem please check its [documentation](http://flysystem.thephpleague.com/).

### JoomlaFolder usage

For common stuff you can do with Flysystem please check its [documentation](http://flysystem.thephpleague.com/).

`JoomlaFolder` adapter supports aliases for commonly used folders. Examples:  

```php
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

### Filesystem events.

Events triggered when a filesystem is loaded.

**onFlysystemBeforeLoadFilesystem** Called before an filesystem instance is created.

```php
/**
 * Triggered before filesystem has been loaded.
 *
 * @param   Filesystem        $filesystem  Loaded environment
 * @param   AdapterInterface  $adapter     Loaded environment
 * @param   array             $config      Options to initialise environment
 *
 * @return  void
 */
public function onFlysystemBeforeLoadFilesystem(Filesystem $filesystem, AdapterInterface &$adapter, &$config = null)
```

**onFlysystemAfterLoadFilesystem** Called after an filesystem instance has been created.

```php
/**
 * Triggered after filesystem has been loaded.
 *
 * @param   Filesystem        $filesystem  Loaded environment
 * @param   AdapterInterface  $adapter     Loaded environment
 * @param   array             $config      Options to initialise environment
 *
 * @return  void
 */
public function onFlysystemAfterLoadFilesystem(Filesystem $filesystem, AdapterInterface $adapter, $config = null)
```

### MountManager events.

**onFlysystemBeforeLoadMountManager** Called before a MountManager instance is created.

```php
/**
 * Triggered before MountManager has been loaded.
 *
 * @param   MountManager      $mountManager  Loaded MountManager
 * @param   array             $filesystems   Filesystems being loaded
 *
 * @return  void
 */
public function onFlysystemBeforeLoadMountManager(MountManager $mountManager, array &$filesystems)
```

**onFlysystemAfterLoadMountManager** Called after a MountManager instance has been created.

```php
/**
 * Triggered after MountManager has been loaded.
 *
 * @param   MountManager      $mountManager  Loaded MountManager
 * @param   array             $filesystems   Filesystems already loaded
 *
 * @return  void
 */
public function onFlysystemAfterLoadMountManager(MountManager $mountManager, array $filesystems)
```


