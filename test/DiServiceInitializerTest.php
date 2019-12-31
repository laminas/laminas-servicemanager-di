<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ServiceManager\Di;

use Interop\Container\ContainerInterface;
use Laminas\Di\Di;
use Laminas\Di\InstanceManager;
use Laminas\ServiceManager\Di\DiInstanceManagerProxy;
use Laminas\ServiceManager\Di\DiServiceInitializer;
use PHPUnit_Framework_TestCase as TestCase;
use stdClass;

class DiServiceInitializerTest extends TestCase
{
    /**
     * @var DiServiceInitializer
     */
    protected $diServiceInitializer = null;

    protected $mockContainer = null;
    protected $mockDi = null;
    protected $mockDiInstanceManagerProxy = null;
    protected $mockDiInstanceManager = null;

    public function setup()
    {
        $this->mockDi = $this->prophesize(Di::class);

        $this->mockContainer = $this->prophesize(ServiceLocatorInterface::class);
        $this->mockContainer->willImplement(ContainerInterface::class);

        $this->mockDiInstanceManager = $this->prophesize(InstanceManager::class);

        $this->mockDiInstanceManagerProxy = new DiInstanceManagerProxy(
            $this->mockDiInstanceManager->reveal(),
            $this->mockContainer->reveal()
        );

        $this->diServiceInitializer = new DiServiceInitializer(
            $this->mockDi->reveal(),
            $this->mockContainer->reveal(),
            $this->mockDiInstanceManagerProxy
        );
    }

    /**
     * @covers Laminas\ServiceManager\Di\DiServiceInitializer::__invoke
     */
    public function testInitializeUsingV2Api()
    {
        $instance = new stdClass();

        // test di is called with proper instance
        $this->mockDi->injectDependencies($instance)->shouldBeCalled();

        $this->diServiceInitializer->__invoke($instance, $this->mockContainer->reveal());
    }

    /**
     * @covers Laminas\ServiceManager\Di\DiServiceInitializer::__invoke
     */
    public function testInitializeUsingV3Api()
    {
        $instance = new stdClass();

        // test di is called with proper instance
        $this->mockDi->injectDependencies($instance)->shouldBeCalled();

        $this->diServiceInitializer->__invoke($this->mockContainer->reveal(), $instance);
    }

    /**
     * @covers Laminas\ServiceManager\Di\DiServiceInitializer::__invoke
     * @todo this needs to be moved into its own class
     */
    public function testProxyInstanceManagersStayInSync()
    {
        $instanceManager = new InstanceManager();
        $proxy = new DiInstanceManagerProxy($instanceManager, $this->mockContainer->reveal());
        $instanceManager->addAlias('foo', 'bar');

        $this->assertEquals($instanceManager->getAliases(), $proxy->getAliases());
    }
}
