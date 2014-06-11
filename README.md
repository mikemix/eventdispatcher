EventDispatcher
===============

Easily attach listeners to ZF2's MVC events.

Installation
------------

1. Add ```"mikemix/eventdispatcher": "1.*"``` to your composer.json file
2. Run ```php composer.phar self-update && php composer.phar update```
3. Add module ```EventDispatcher``` to your application modules in the ```application.config.php``` file
4. Copy file ```vendor/mikemix/eventdispatcher/config/event_dispatcher.global.php.dist``` to the ```config/autoload/event_dispatcher.global.php```

Congratulations. You are done and the library has been successfully installed (hope so). To subscribe to a mvc event, it is as simple as adding a name of your listener service name to the ```event_dispatcher.global.php``` file. The name must be recognized by the service manager.

Example configuration
---------------------

File ```config/autoload/event_dispatcher.config.php```

```php
return array(
    'event_dispatcher' => array(
        'dispatch' => array(
            // dispatch listeners here
            'myDispatchListener'       # <----------------- NOTICE
        ),
        'dispatch.error' => array(
            // dispatch.error listeners here
        ),
        'finish' => array(
            // finish listeners here
        ),
        'render' => array(
            // render listeners here
        ),
        'render.error' => array(
            // render.error listeners here
        ),
        'route' => array(
            // route listeners here
        ),
    ),
);
```

File ```module/Application/config/module.config.php```

```php
// ...
'service_manager' => array(
    // ...
    
    'invokables' => array(
        'myDispatchListener' => 'Application\Listener\DispatchListener',
    ),
),
```

File ```module/Application/src/Application/Listener/DispatchListener.php```. For your convienience and type hinting for the editor of your choice, you can make the listener implement the ListenerInterface interface, but you are not obliged to. Just make sure an ```onEvent()``` method is available for calling.

```php
<?php
namespace Application\Listener;

use EventDispatcher\Listener\ListenerInterface;

class DispatchListener implements ListenerInterface
{
    public function onEvent(EventInterface $event)
    {
        printf('Well hello, a %s event was called', $event->getName());
    }
}
```
