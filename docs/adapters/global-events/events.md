### Global events. <a id="global-adapters-events"></a>

These events allow to perform common actions for all the adapters with a single entry point.

**onFlysystemBeforeLoadAdapter** Called before an AdapterInterface instance is created. <a id="onFlysystemBeforeLoadAdapter"></a>

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

**onFlysystemAfterLoadAdapter** Called after an AdapterInterface instance has been created. <a id="onFlysystemAfterLoadAdapter"></a>

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