<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ServiceManager\Di;

use Interop\Container\ContainerInterface;
use Laminas\Di\Di;
use Laminas\ServiceManager\Di\DiFactory;
use PHPUnit\Framework\TestCase;

class DiFactoryTest extends TestCase
{
    public function testWillInitializeDiAndDiAbstractFactory()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->willReturn(true);
        $container->get('config')->willReturn(['di' => ['']]);

        $factory = new DiFactory();
        $di = $factory($container->reveal(), Di::class);

        $this->assertInstanceOf(Di::class, $di);
    }
}
