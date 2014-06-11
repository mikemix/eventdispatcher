<?php
namespace EventDispatcherTest\EventManager;

use EventDispatcher\EventManager\Dispatcher;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testDoNothingWhenNoConfiguration()
    {
        $service = new Dispatcher(array(), $this->getServiceLocatorStub());
        $service->attachListeners($this->getEventManagerStub());
    }

    public function testListenersGetAttachedToAllEventsOnlyIfHasListeners()
    {
        $service = new Dispatcher(
            array(
                'bootstrap' => array('someServiceId'),
                'dispatch' => array('someServiceId'),
                'dispatch.error' => array('someServiceId'),
                'finish' => array('someServiceId'),
                'render' => array('someServiceId'),
                'render.error' => array(),
                'route' => array(),
            ),
            $this->getServiceLocatorStub()
        );

        $evm = $this->getEventManagerStub();
        $evm->expects($this->exactly(5))
            ->method('attach');

        $service->attachListeners($evm);
    }

    public function testAttachWithAdditionalPriority()
    {
        $service = new Dispatcher(
            array('dispatch' => array('someServiceId' => 1000)),
            $this->getServiceLocatorStub()
        );

        $evm = $this->getEventManagerStub();
        $evm
            ->expects($this->once())
            ->method('attach')
            ->with($this->equalTo('dispatch'), $this->anything(), $this->equalTo(1000));

        $service->attachListeners($evm);
    }

    protected function getEventManagerStub()
    {
        return $this->getMock('Zend\EventManager\EventManagerInterface');
    }

    protected function getServiceLocatorStub()
    {
        return $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
    }
}
