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
use Laminas\ServiceManager\Di\DiServiceFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class DiServiceFactoryTest extends TestCase
{
    /**
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::__construct
     */
    public function testConstructor()
    {
        $instance = new DiServiceFactory(
            $this->prophesize(Di::class)->reveal()
        );
        $this->assertInstanceOf(DiServiceFactory::class, $instance);
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::createService
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::get
     */
    public function testCreateService()
    {
        $fooInstance = new stdClass();

        $instanceManager = new InstanceManager();
        $instanceManager->addSharedInstanceWithParameters(
            $fooInstance,
            'foo',
            ['bar' => 'baz']
        );

        $container = $this->prophesize(ContainerInterface::class);

        $di = new Di(null, $instanceManager);
        $diServiceFactory = new DiServiceFactory($di);

        $foo = $diServiceFactory->__invoke($container->reveal(), 'foo', ['bar' => 'baz']);
        $this->assertSame($fooInstance, $foo);
    }

    public function testCreateServiceWithNullOptions()
    {
        $fooInstance = new stdClass();

        $instanceManager = new InstanceManager();
        $instanceManager->addSharedInstance($fooInstance, 'foo');

        $di = new Di(null, $instanceManager);
        $diServiceFactory = new DiServiceFactory($di);

        $container = $this->prophesize(ContainerInterface::class);

        $foo = $diServiceFactory->__invoke($container->reveal(), 'foo');
        $this->assertSame($fooInstance, $foo);
    }

    public function testCreateServiceV2V3()
    {
        $fooInstance = new stdClass();

        $instanceManager = new InstanceManager();
        $instanceManager->addSharedInstanceWithParameters(
            $fooInstance,
            'foo',
            ['bar' => 'baz']
        );

        $container = $this->prophesize(ServiceLocatorInterface::class)
            ->willImplement(ContainerInterface::class);

        $di = new Di(null, $instanceManager);
        $diServiceFactoryV3 = new DiServiceFactory($di);
        $diServiceFactoryV2 = new DiServiceFactory($di);
        $diServiceFactoryV2->setCreationOptions(['bar' => 'baz']);

        $fooV3 = $diServiceFactoryV3->__invoke($container->reveal(), 'foo', ['bar' => 'baz']);
        $this->assertSame($fooInstance, $fooV3);

        $fooV2 = $diServiceFactoryV2->createService($container->reveal(), 'foo');
        $this->assertSame($fooInstance, $fooV2);

        $this->assertSame($fooV3, $fooV2);
    }
}
