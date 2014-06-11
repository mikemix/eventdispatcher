<?php
namespace EventDispatcher\EventManager;

use Zend\EventManager\EventManagerInterface;
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
        $events = array(
            'bootstrap', 'dispatch', 'dispatch.error', 'finish', 'render', 'render.error', 'route'
        );
        
        foreach ($events as $event) {
            if (isset($this->config($event)) && count($this->config[$event]) > 0) {
                $this->attachFor($eventManager, $event);
            }
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
            $eventManager->attach($eventName, function ($event) use ($sm, $serviceName) {
                $listener = $sm->get($serviceName);
                return $listener->onEvent($event);
            }, $priority);
        }
    }
}
