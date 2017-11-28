## Azure Adapter

Wrapper for [Flysystem adapter for the Windows Azure](https://github.com/thephpleague/flysystem-azure) with Joomla events support. 

1. [Usage](#usage)
2. [Events](#events)
    * [Global events](#global-adapters-events)
        * [onFlysystemBeforeLoadAdapter](#onFlysystemBeforeLoadAdapter)
        * [onFlysystemAfterLoadAdapter](#onFlysystemAfterLoadAdapter)
    * [Custom events](#custom-events)
        * [onFlysystemBeforeLoadAzureAdapter](#onFlysystemBeforeLoadAzureAdapter)
        * [onFlysystemAfterLoadAzureAdapter](#onFlysystemAfterLoadAzureAdapter)

### 1. Usage <a id="usage"></a>

To use the adapter programmatically you can use: 

```php
JLoader::import('flysystem.library');

use MicrosoftAzure\Storage\Common\ServicesBuilder;
use Phproberto\Joomla\Flysystem\Filesystem;
use Phproberto\Joomla\Flysystem\Adapter\Azure;

$endpoint = sprintf(
    'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
    'account-name',
    'api-key'
);

$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($endpoint);

$filesystem = new Filesystem(new Azure($blobRestProxy, 'my-container'));
```

### 2. Events <a id="events"></a>

{% include_relative global/events.md %}

### Custom events <a id="custom-events"></a>

**onFlysystemBeforeLoadAzureAdapter** Called before an Azure adapter instance is created.<a id="onFlysystemBeforeLoadAzureAdapter"></a>

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

**onFlysystemAfterLoadAzureAdapter** Called after an Azure adapter instance has been created.<a id="onFlysystemAfterLoadAzureAdapter"></a>

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