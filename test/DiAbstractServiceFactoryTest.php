<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ServiceManager\Di;

use Interop\Container\ContainerInterface;
use Laminas\Di\Definition\DefinitionInterface;
use Laminas\Di\Di;
use Laminas\Di\InstanceManager;
use Laminas\ServiceManager\Di\DiAbstractServiceFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use stdClass;

class DiAbstractServiceFactoryTest extends TestCase
{
    /**
     * @var DiAbstractServiceFactory
     */
    protected $diAbstractServiceFactory;

    /** @var stdClass */
    protected $fooInstance;

    /** @var ContainerInterface|ServiceLocatorInterface|ObjectProphecy */
    protected $mockContainer;

    protected function setUp()
    {
        $this->fooInstance = new stdClass();

        $instanceManager = new InstanceManager();
        $instanceManager->addSharedInstance($this->fooInstance, 'foo');

        $di = new Di(null, $instanceManager);

        $this->mockContainer = $this->prophesize(ServiceLocatorInterface::class);
        $this->mockContainer->willImplement(ContainerInterface::class);

        $this->diAbstractServiceFactory = new DiAbstractServiceFactory($di);
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::__construct
     */
    public function testConstructor()
    {
        $instance = new DiAbstractServiceFactory(
            $this->prophesize(Di::class)->reveal()
        );
        $this->assertInstanceOf(DiAbstractServiceFactory::class, $instance);
    }

    /**
     * @group 6021
     *
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::createServiceWithName
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::get
     */
    public function testCreateServiceWithNameAndWithoutRequestName()
    {
        $foo = $this->diAbstractServiceFactory->createServiceWithName(
            $this->mockContainer->reveal(),
            'foo',
            null
        );
        $this->assertEquals($this->fooInstance, $foo);
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::createServiceWithName
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::get
     */
    public function testCreateServiceWithName()
    {
        $foo = $this->diAbstractServiceFactory->createServiceWithName(
            $this->mockContainer->reveal(),
            'foo',
            'foo'
        );
        $this->assertEquals($this->fooInstance, $foo);
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiAbstractServiceFactory::canCreateServiceWithName
     */
    public function testCanCreateServiceWithName()
    {
        $instance = new DiAbstractServiceFactory(new Di());
        $im = $instance->instanceManager();

        $container = $this->prophesize(ServiceLocatorInterface::class);
        $container->willImplement(ContainerInterface::class);

        // will check shared instances
        $this->assertFalse($instance->canCreateServiceWithName(
            $container->reveal(),
            'a-shared-instance-alias',
            'a-shared-instance-alias'
        ));
        $im->addSharedInstance(new stdClass(), 'a-shared-instance-alias');
        $this->assertTrue($instance->canCreateServiceWithName(
            $container->reveal(),
            'a-shared-instance-alias',
            'a-shared-instance-alias'
        ));

        // will check aliases
        $this->assertFalse($instance->canCreateServiceWithName($container->reveal(), 'an-alias', 'an-alias'));
        $im->addAlias('an-alias', 'stdClass');
        $this->assertTrue($instance->canCreateServiceWithName($container->reveal(), 'an-alias', 'an-alias'));

        // will check instance configurations
        $this->assertFalse($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\Non\Existing',
            __NAMESPACE__ . '\Non\Existing'
        ));
        $im->setConfig(__NAMESPACE__ . '\Non\Existing', ['parameters' => ['a' => 'b']]);
        $this->assertTrue($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\Non\Existing',
            __NAMESPACE__ . '\Non\Existing'
        ));

        // will check preferences for abstract types
        $this->assertFalse($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\AbstractClass',
            __NAMESPACE__ . '\AbstractClass'
        ));
        $im->setTypePreference(__NAMESPACE__ . '\AbstractClass', [__NAMESPACE__ . '\Non\Existing']);
        $this->assertTrue($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\AbstractClass',
            __NAMESPACE__ . '\AbstractClass'
        ));

        // will check definitions
        $def = $instance->definitions();
        $this->assertFalse($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\Other\Non\Existing',
            __NAMESPACE__ . '\Other\Non\Existing'
        ));

        $classDefinition = $this->prophesize(DefinitionInterface::class);
        $classDefinition->hasClass(__NAMESPACE__ . '\Other\Non\Existing')->willReturn(true);
        $classDefinition->getClasses()->willReturn([__NAMESPACE__ . '\Other\Non\Existing']);

        $def->addDefinition($classDefinition->reveal());
        $this->assertTrue($instance->canCreateServiceWithName(
            $container->reveal(),
            __NAMESPACE__ . '\Other\Non\Existing',
            __NAMESPACE__ . '\Other\Non\Existing'
        ));
    }
}
