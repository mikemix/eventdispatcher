<?php
namespace EventDispatcher\EventManager;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\MvcEvent;

class Dispatcher
{
    protected $config = array();
    protected $sm;

    public function __construct(array $config, ServiceLocatorInterface $sm)
    {
        $this->config = $config;
        $this->sm = $sm;
    }
    
    public function attachListeners(EventManagerInterface $eventManager)
    {
        if (isset($this->config[MvcEvent::EVENT_DISPATCH])) {
            $this->attachFor($eventManager, MvcEvent::EVENT_DISPATCH);
        }
    }

    protected function attachFor(EventManagerInterface $eventManager, $eventName)
    {
        foreach ($this->config[$eventName] as $serviceName => $priority) {
            if (is_numeric($serviceName)) {
                // not an associative array
                $serviceName = $priority;
                $priority = 1;
            }
            
            $sm = $this->sm;
            $eventManager->attach($eventName, function (EventInterface $e) use ($sm, $serviceName) {
                $listener = $sm->get($serviceName);
                return $listener->onEvent($e);
            }, $priority);
        }
    }
}
