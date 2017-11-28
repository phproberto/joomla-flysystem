# Flysystem integration for Joomla!

> Integrate [Flysystem](http://flysystem.thephpleague.com/) with Joomla!

NOTE: This is a work in progress shared to get feedback.

* [Description](#description)
* [Installation](#installation)
* [Documentation](#documentation)
* [Requirements](#requirements)
* [Copyright & License](#license)

## Description. <a id="description"></a>

This is a way to provide an extendable system to easily access, from Joomla, files stored anywhere (Dropbox, AWS, and any existing adapter that exists or that you want to create). 

### Installation. <a id="installation"></a>

This repository does not contain a joomla installable package. It's the main source of the code used by a library that I will distribute as soon as a stable version is released.

As soon as a packagist library is available I will update this to add information to use it through composer.  

### Documentation. <a id="documentation"></a>

I've created a nice [Documentation](https://phproberto.github.io/joomla-flysystem) with a lot of information to understand what is this and how to use it.

## Requirements <a id="requirements"></a>

* PHP 7.0+ or higher
* Joomla! 3.8.1 or higher

## Copyright & License <a id="license"></a>

This library is licensed under [MIT LICENSE](./LICENSE).  

The Joomla! installable package that will contain this library will have its own GPL v2 license because it's extending Joomla classes licensed under that license. 

Copyright (C) 2017 [Roberto Segura López](http://phproberto.com) - All rights reserved.  