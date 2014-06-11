<?php
namespace EventDispatcher\EventManager;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Dispatcher
{
    /**
     * List of supported events.
     *
     * @var array
     */
    protected $events = array(
        'bootstrap', 'dispatch', 'dispatch.error', 'finish', 'render', 'render.error', 'route'
    );

    /**
     * List of event listeners from the configuration.
     *
     * @var array
     */
    protected $config = array();

    /**
     * The service locator.
     *
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $sm;

    public function __construct(array $config, ServiceLocatorInterface $sm)
    {
        $this->config = $config;
        $this->sm = $sm;
    }
    
    public function attachListeners(EventManagerInterface $eventManager)
    {
        foreach ($this->events as $event) {
            if (isset($this->config[$event]) && count($this->config[$event]) > 0) {
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
