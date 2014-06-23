<?php
namespace EventDispatcher\Listener;

use Zend\EventManager\EventInterface;

interface ListenerInterface
{
    /**
     * @var EventInterface|\Zend\Mvc\MvcEvent $event
     * @return mixed
     */
    public function onEvent(EventInterface $event);
}
