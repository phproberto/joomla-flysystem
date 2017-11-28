## Quick start

The easier way to start using joomla-twig to access files is to use `FileServer` which is a central place to access all available file systems:

```php
JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\FileServer;

$fileServer = FileServer::instance();

if ($fileServer->has('site://README.md'))
{
	echo "Your site has a readme file";
}

if ($fileServer->has('image://headers/walden-pond.jpg'))
{
	echo '<img src="data:image/jpg;base64,' . base64_encode($fileServer->read('image://headers/walden-pond.jpg')) . '" />';
}
```