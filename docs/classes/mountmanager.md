## MountManager class

This class extends [Flysystem MountManager](https://github.com/thephpleague/flysystem/blob/master/src/MountManager.php) to trigger events that joomla plugin can use to load custom file systems.  

1. [Usage](#usage)
2. [Events](#events)
    * [onFlysystemBeforeLoadMountManager](#onFlysystemBeforeLoadMountManager)
    * [onFlysystemAfterLoadMountManager](#onFlysystemAfterLoadMountManager)

### 1. Usage <a id="usage"></a>

You shouldn't need to use this class programmatically because FileServer already does it through an unique instance that ensures that things are only loaded once.  

You can however use it like this is you are adding filesystems to use them programmatically:  

```php
use JLoader::import('flysystem.library');

use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\MountManager;
use Phproberto\Joomla\Flysystem\Adapter\JoomlaFolder;

$filesystems = [
	'com_sample-site' => new Filesystem(new JoomlaFolder('components/com_sample')),
	'com_sample-admin' => new Filesystem(new JoomlaFolder('administrator/components/com_sample'))
];

// This manager will be able to access default prefixes + your custom ones
$manager = new MountManager($filesystems);

if ($manager->has(com_sample-site://models/books.php))
{
	echo "My component has a books model!";
}
```

### 2. Events <a id="events"></a>

This class provides this events to be able to load custom filesystems through plugins and other cool stuff you can imagine:  

**onFlysystemBeforeLoadMountManager** Called before a MountManager instance is created.<a id="onFlysystemBeforeLoadMountManager"></a>

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

**onFlysystemAfterLoadMountManager** Called after a MountManager instance has been created.<a id="onFlysystemAfterLoadMountManager"></a>

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
