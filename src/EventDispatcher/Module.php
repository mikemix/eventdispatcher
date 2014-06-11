<?php
namespace EventDispatcher;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app          = $e->getApplication();
        $eventManager = $app->getEventManager();
        $sm           = $app->getServiceManager();

        $dispatcher = $sm->get('mikemix.dispatcher');
        $eventManager->attachAggregate($dispatcher);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'mikemix.dispatcher' => 'EventDispatcher\EventManager\Factory\DispatcherFactory',
            ),
        );
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }
}
