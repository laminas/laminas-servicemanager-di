<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ServiceManager\Di\TestAsset;

use Laminas\Stdlib\DispatchableInterface;
use Laminas\Stdlib\RequestInterface;
use Laminas\Stdlib\ResponseInterface;
use stdClass;

class ControllerWithDependencies implements DispatchableInterface
{
    /**
     * @var stdClass
     */
    public $injectedValue;

    /**
     * @param stdClass $injected
     */
    public function setInjectedValue(stdClass $injected)
    {
        $this->injectedValue = $injected;
    }

    public function dispatch(RequestInterface $request, ResponseInterface $response = null)
    {
    }
}
