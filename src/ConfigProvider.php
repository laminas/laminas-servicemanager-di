<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ServiceManager\Di;

use Laminas\Di\LocatorInterface;

class ConfigProvider
{
    /**
     * Return configuration for applications.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency configuration.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return[
            'aliases' => [
                'Di'                    => 'DependencyInjector',
                LocatorInterface::class => 'DependencyInjector',

                // Legacy Zend Framework aliases
                \Zend\Di\LocatorInterface::class => LocatorInterface::class,
            ],
            'factories' => [
                'DependencyInjector'             => DiFactory::class,
                'DiAbstractServiceFactory'       => DiAbstractServiceFactoryFactory::class,
                'DiServiceInitializer'           => DiServiceInitializerFactory::class,
                'DiStrictAbstractServiceFactory' => DiStrictAbstractServiceFactoryFactory::class,
            ],
        ];
    }
}
