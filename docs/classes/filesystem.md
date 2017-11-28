## Filesystem class

This class extends [Flysystem Filesystem class](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php) to trigger events that joomla plugins can use to customise filesystem when they are loaded.

1. [Usage](#usage)
2. [Events](#events)
    * [onFlysystemBeforeLoadFilesystem](#onFlysystemBeforeLoadFilesystem)
    * [onFlysystemAfterLoadFilesystem](#onFlysystemAfterLoadFilesystem)

### 1. Usage <a id="usage"></a>

You may use this class to provide access to your custom adapter while allowing plugins to connect their own logic.  

```php
use JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;

$moduleFiles = new Filesystem(new JoomlaFolder('modules/mod_menu'));

if ($moduleFiles->has('mod_menu.php'))
{
	echo "The module entry point exists!";
}
```

### 2. Events <a id="events"></a>

**onFlysystemBeforeLoadFilesystem** Called before an filesystem instance is created.<a id="onFlysystemBeforeLoadFilesystem"></a>

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

**onFlysystemAfterLoadFilesystem** Called after an filesystem instance has been created.<a id="onFlysystemAfterLoadFilesystem"></a>

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
