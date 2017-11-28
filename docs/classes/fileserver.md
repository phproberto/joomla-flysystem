## FileServer class

This class provides global access to all the filesystems registered in Joomla! programmatically or through plugins.  

### Usage

```php
use JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\FileServer;

$files = FileServer::instance();

// From here you can use any prefix registered by JoomlaFolder or plugins to access a specific file system.
if ($files->has('admin://index.php')
{
	echo "Backend is not broken!";
}

// Example usage for custom plugin prefix `company`
if ($files->has('company://images/logo.png')
{
	echo "We have a nice logo";
}
```
