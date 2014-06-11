<?php
namespace EventDispatcher\EventManager;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class Dispatcher implements ListenerAggregateInterface
{
    protected $config = array();
    protected $listeners = array();

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, function () use ($events) {
            
        });
    }

    function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($e->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
