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
     * @var DiServiceFactory
     */
    protected $diServiceFactory;

    protected $mockContainer;
    protected $mockDi;
    protected $fooInstance;

    protected function setUp()
    {
        $instanceManager = new InstanceManager();
        $instanceManager->addSharedInstanceWithParameters(
            $this->fooInstance = new stdClass(),
            'foo',
            ['bar' => 'baz']
        );
        $this->mockDi = $this->getMockBuilder(Di::class)
            ->setConstructorArgs([null, $instanceManager])
            ->getMock();

        $this->mockContainer = $this->prophesize(ServiceLocatorInterface::class);
        $this->mockContainer->willImplement(ContainerInterface::class);

        $this->diServiceFactory = new DiServiceFactory(
            $this->mockDi,
            ['bar' => 'baz']
        );
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::__construct
     */
    public function testConstructor()
    {
        $instance = new DiServiceFactory(
            $this->prophesize(Di::class)->reveal(),
            ['foo' => 'bar']
        );
        $this->assertInstanceOf(DiServiceFactory::class, $instance);
    }

    /**
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::createService
     * @covers \Laminas\ServiceManager\Di\DiServiceFactory::get
     */
    public function testCreateService()
    {
        // check if v2 vs v3
        $foo = $this->diServiceFactory->__invoke($this->mockContainer->reveal(), 'foo', ['bar' => 'baz']);
        $this->assertEquals($this->fooInstance, $foo);
    }
}
