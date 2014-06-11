<?php
namespace EventDispatcher\EventManager\Factory;

use EventDispatcher\EventManager\Dispatcher;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DispatcherFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $zfConfig = $sm->get('config');
        $config = isset($zfConfig['event_dispatcher']) ? $zfConfig['event_dispatcher'] : array();
    
        $service = new Dispatcher($config);
        return $service;
    }
}
