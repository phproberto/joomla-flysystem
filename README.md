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

### How to use it?

For common stuff you can do with Flysystem please check its [documentation]([Flysystem](http://flysystem.thephpleague.com/).

This is a fast preview of what is already implemented:  

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