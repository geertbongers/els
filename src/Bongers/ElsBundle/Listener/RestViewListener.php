<?php
namespace Bongers\ElsBundle\Listener;

class RestViewListener
{
    public function onEvent($event)
    {
        $controller = $event->getController();
        $response = $event->getResponse();

        if (is_array($response)) {
            $response = new Response($event, $controller->getResponseCode());
        }

        return $response;
    }
}
