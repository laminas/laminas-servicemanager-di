<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ServiceManager\Di;

use Exception;
use Interop\Container\ContainerInterface;
use Laminas\Di\Di;
use Laminas\ServiceManager\AbstractPluginManager;

class DiServiceInitializer extends Di
{
    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * @var Di
     */
    protected $di = null;

    /**
     * @var DiInstanceManagerProxy
     */
    protected $diInstanceManagerProxy = null;

    /**
     * @param Di $di
     * @param ContainerInterface $container
     * @param null|DiInstanceManagerProxy $diImProxy
     */
    public function __construct(
        Di $di,
        ContainerInterface $container,
        DiInstanceManagerProxy $diInstanceManagerProxy = null
    ) {
        $this->di = $di;
        $this->container = $container;
        $this->diInstanceManagerProxy = $diInstanceManagerProxy ?: new DiInstanceManagerProxy(
            $di->instanceManager(),
            $container
        );
    }

    /**
     * Initialize an instance via laminas-di.
     *
     * @param mixed|ContainerInterface $first Container when under
     *     laminas-servicemanager v3, instance to initialize otherwise.
     * @param ContainerInterface|mixed $second Instance to initialize when
     *     under laminas-servicemanager v3, container otherwise.
     * @return void
     */
    public function __invoke($first, $second)
    {
        if ($first instanceof AbstractPluginManager
            || $second instanceof ContainerInterface
        ) {
            $instance  = $first;
        } else {
            $instance  = $second;
        }

        $instanceManager = $this->di->instanceManager;
        $this->di->instanceManager = $this->diInstanceManagerProxy;

        try {
            $this->di->injectDependencies($instance);
        } catch (Exception $e) {
            throw $e;
        } finally {
            $this->di->instanceManager = $instanceManager;
        }
    }
}
