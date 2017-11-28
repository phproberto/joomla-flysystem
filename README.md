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

### Usage.

Check [Documentation](https://phproberto.github.io/joomla-flysystem) to get information about how to use it.

## Requirements <a id="requirements"></a>

* PHP 7.0+ or higher
* Joomla! 3.8.1 or higher

## Copyright & License <a id="license"></a>

This library is licensed under [MIT LICENSE](./LICENSE).  

Copyright (C) 2017 [Roberto Segura López](http://phproberto.com) - All rights reserved.  