## What is this?

This is a library to integrate a cool filesystem abstraction named [Flysystem](http://flysystem.thephpleague.com/) with Joomla!  

### Flysystem benefits 

This information is extracted from [Flysystem docs](http://flysystem.thephpleague.com/)

* Have a generic API for handling common tasks across multiple file storage engines.
* Have consistent output which you can rely on.
* Integrate well with other packages/frameworks.
* Be cacheable.
* Emulate directories in systems that support none, like AwsS3.
* Support third party plugins.
* Make it easy to test your filesystem interactions.
* Support streams for big file handling

### Joomla-Twig features

* Fully compatible with Flysystem.
* Provides wrappers for Flysystem classes to trigger events that joomla plugins can use to customise interaction. 
* Provides a JoomlaFolder which allows access to common joomla folders in a simple common way.
* 100% unit covered by tests.
