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