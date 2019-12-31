# Migration: From laminas-mvc v2 DI/ServiceManager integration

laminas-servicemanager-di ports all DI integration present in:

- [laminas-servicemanager](https://docs.laminas.dev/laminas-servicemanager), and
- [laminas-mvc](https://docs.laminas.dev/laminas-mvc)

to a single, optional component. As such, a number of classes were renamed that
may impact end-users.

## laminas-servicemanager functionality

The following classes were originally in laminas-servicemanager, but are now
shipped as part of this package:

- `Laminas\ServiceManager\Di\DiAbstractServiceFactory`
- `Laminas\ServiceManager\Di\DiInstanceManagerProxy`
- `Laminas\ServiceManager\Di\DiServiceFactory`
- `Laminas\ServiceManager\Di\DiServiceInitializer`

Some functionality was altered slightly to allow usage under both
laminas-servicemanager v2 and v3, including how instance names and
instance-specific parameters are handled.

### DiServiceFactory

The constructor was changed to remove the `$name` and `$parameters` arguments.
These are now passed at invocation of the factory instead, making it perform
more correctly with relation to other `FactoryInterface` implementations.

## laminas-mvc functionality

The following classes were renamed:

- `Laminas\Mvc\Service\DiAbstractServiceFactoryFactory` was renamed to
  `Laminas\ServiceManager\Di\DiAbstractServiceFactoryFactory`.
- `Laminas\Mvc\Service\DiServiceInitializerFactory` was renamed to
  `Laminas\ServiceManager\Di\DiServiceInitializerFactory`.
- `Laminas\Mvc\Service\DiFactory` was renamed to
  `Laminas\ServiceManager\Di\DiFactory`.
- `Laminas\Mvc\Service\DiStrictAbstractServiceFactory` was renamed to
  `Laminas\ServiceManager\Di\DiStrictAbstractServiceFactory`
- `Laminas\Mvc\Service\DiStrictAbstractServiceFactoryFactory` was renamed to
  `Laminas\ServiceManager\Di\DiStrictAbstractServiceFactoryFactory`

All of the above are registered under service names identical to those used in
v2 versions of laminas-mvc, meaning no change in usage for the majority of use
cases.
