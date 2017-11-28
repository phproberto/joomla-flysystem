# Flysystem integration for Joomla!

> Integrate [Flysystem](http://flysystem.thephpleague.com/) with Joomla!

NOTE: This is a work in progress shared to get feedback.

## What is this?

This is a way to provide an extendable system to easily access from Joomla to files stored anywhere (dropbox, AWS, and any existing adapter that exists or you want to create). 

### Benefits

* Manage externally stored files in an easy way as if they were stored locally.
* Access joomla files in an abstracted way that allows to move files around without breaking actual code.
* All the filesystems and mount manager have events before and after being loaded so it's highly customisable.
* You can add custom adapters through plugins.
* Provides a `FileServer` class to access all the existing filesystems in a single and easy way.
* All the classes are still usable separately to provide maximum flexibility for devs.

### Supported adapters.

All the [official adapters](https://github.com/thephpleague/flysystem#adapters) are supported but this library provides specific wrappers for most commonly used adapters. Using this specific adapters allows joomla plugins to connect when an adapter or filesystem is loaded to allow customisations.

Available wrappers:

* [AWS S3 v3](./src/Adapter/AwsS3.php). Load files stored in AWS S3.
* [Azure](./src/Adapter/Azure.php). Load files stored in Azure.
* [Dropbox](./src/Adapter/Dropbox.php). Load files stored in Dropbox.
* [Ftp](./src/Adapter/Ftp.php). Load files stored in an FTP server.
* [JoomlaFolder](./src/Adapter/JoomlaFolder.php). Load files from the joomla site.
* [WebDAV](./src/Adapter/WebDAB.php). Load WebDAV files.
* [ZipFile](./src/Adapter/ZipFile.php). Load & store files from zip files. Requires `php-zip` extension installed.

For common stuff you can do with Flysystem please check its [documentation]([Flysystem](http://flysystem.thephpleague.com/).

### JoomlaFolder usage

For common stuff you can do with Flysystem please check its [documentation]([Flysystem](http://flysystem.thephpleague.com/).

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

### Global adapters events.

These events allow to perform common actions for all the adapters with a single entry point.

**onFlysystemBeforeLoadAdapter** Called before an AdapterInterface instance is created.

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   AdapterInterface  $adapter  Adapter being instatiated
 *
 * @return  void
 */
public function onFlysystemBeforeLoadAdapter(AdapterInterface $adapter)
```

**onFlysystemAfterLoadAdapter** Called after an AdapterInterface instance has been created.

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   AdapterInterface  $adapter  Adapter being instatiated
 *
 * @return  void
 */
public function onFlysystemAfterLoadAdapter(AdapterInterface $adapter)
```

### Specific adapters events

These events provide more arguments to allow more accurate customisations.

**onFlysystemBeforeLoadAwsS3Adapter** Called before an AwsS3 adapter instance is created.

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

**onFlysystemAfterLoadAwsS3Adapter** Called after an AwsS3 adapter instance has been created.

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

**onFlysystemBeforeLoadAzureAdapter** Called before an Azure adapter instance is created.

```php
/**
 * Triggered before adapter has been loaded.
 *
 * @param   Azure   $adapter      Adapter being instatiated
 * @param   IBlob   $azureClient  Client to connect.
 * @param   string  $container    Name of the container
 * @param   string  $prefix       Optional prefix.
 *
 * @return  void
 */
public function onFlysystemBeforeLoadAzureAdapter(Azure $adapter, IBlob $azureClient, &$container, &$prefix = null)
```

**onFlysystemAfterLoadAzureAdapter** Called after an Azure adapter instance has been created.

```php
/**
 * Triggered after adapter has been loaded.
 *
 * @param   Azure   $adapter      Adapter being instatiated
 * @param   IBlob   $azureClient  Client to connect.
 * @param   string  $container    Name of the container
 * @param   string  $prefix       Optional prefix.
 *
 * @return  void
 */
public function onFlysystemAfterLoadAzureAdapter(Azure $adapter, IBlob $azureClient, $container, $prefix = null)
```

**onFlysystemBeforeLoadDropboxAdapter** Called before a Dropbox adapter instance has been created.

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

**onFlysystemAfterLoadDropboxAdapter** Called after a Dropbox adapter instance has been created.

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

**onFlysystemBeforeLoadFtpAdapter** Called before an FTP adapter instance has been created.

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

**onFlysystemAfterLoadFtpAdapter** Called after an FTP adapter instance has been created.

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

**onFlysystemBeforeLoadJoomlaFolderAdapter** Called before an JoomlaFolder adapter instance has been created.

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

**onFlysystemAfterLoadJoomlaFolderAdapter** Called after an JoomlaFolder adapter instance has been created.

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

**onFlysystemBeforeLoadWebDAVAdapter** Called before a WebDAV adapter instance has been created.

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

**onFlysystemAfterLoadWebDAVAdapter** Called after a WebDAV adapter instance has been created.

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

**onFlysystemBeforeLoadZipFileAdapter** Called after a ZipFile adapter instance has been created.

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

**onFlysystemAfterLoadZipFileAdapter** Called after a ZipFile adapter instance has been created.

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
