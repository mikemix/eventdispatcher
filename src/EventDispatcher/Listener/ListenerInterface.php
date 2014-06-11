<?php
namespace EventDispatcher\Listener;

use Zend\EventManager\EventInterface;

interface ListenerInterface
{
    public function onEvent(EventInterface $event);
}
