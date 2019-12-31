## Installation

### Using Composer

```bash
$ composer require laminas/laminas-servicemanager-di
```

If you are using the [laminas-component-installer](https://docs.laminas.dev/laminas-component-installer),
you're done!


If not, you will need to add the component as a module to your
application. Add the entry `'Laminas\ServiceManager\Di'` to
your list of modules in your application configuration (typically
one of `config/application.config.php` or `config/modules.config.php`).

## Usage

The code in this package augments [laminas-servicemanager](https://docs.laminas.dev/laminas-servicemanager/),
providing integration with [laminas-di](https://github.com/laminas/laminas-di).
Read the [Services](services.md) chapter for details.
