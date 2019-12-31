# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.2.1 - 2019-10-18

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-servicemanager-di#18](https://github.com/zendframework/zend-servicemanager-di/pull/18) fixes `Laminas\ServiceManager\Di\DiServiceFactory::__invoke`
  when parameter `$options` is `null`.

## 1.2.0 - 2018-04-30

### Added

- [zendframework/zend-servicemanager-di#16](https://github.com/zendframework/zend-servicemanager-di/pull/16) adds support for 7.2.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- [zendframework/zend-servicemanager-di#16](https://github.com/zendframework/zend-servicemanager-di/pull/16) removes support for HHVM.

### Fixed

- Nothing.

## 1.1.1 - 2017-09-28

### Added

- [zendframework/zend-servicemanager-di#12](https://github.com/zendframework/zend-servicemanager-di/pull/12) adds
  support for PHP 7.1 and 7.2.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-servicemanager-di#3](https://github.com/zendframework/zend-servicemanager-di/pull/3) fixes a
  number of import statements, removing several unused statements, adding
  missing statements, and fixing those refering to container-interop interfaces.

## 1.1.0 - 2016-06-13

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- [zendframework/zend-servicemanager-di#1](https://github.com/zendframework/zend-servicemanager-di/pull/1) removes
  support for laminas-servicemanager v2. Because this package duplicated several
  classes from laminas-servicemanager v2, it caused conflicts, which could be
  observed when generating an optimized autoloader with Composer.
- [zendframework/zend-servicemanager-di#1](https://github.com/zendframework/zend-servicemanager-di/pull/1) removes
  support for PHP 5.5, marking PHP 5.6 as the minimum supported version.

### Fixed

- Nothing.

## 1.0.2 - TBD

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.1 - 2016-06-09

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Imports a patch from [laminas-mvc](https://github.com/zendframework/zend-mvc/pull/149)
  that fixes some issues with the `DiAbstractServiceFactoryFactory` due to
  incorrect variable names and import statements.

## 1.0.0 - 2016-04-06

First stable release.

This package replaces the laminas-servicemanager <-> laminas-di integration originally
found in laminas-servicemanager and laminas-mvc in the v2 releases.

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
