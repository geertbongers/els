<?php
namespace Bongers\ElsBundle\Listener;

class ParamConverterListener
{
    /**
     * @var \Bongers\ElsBundle\ParamConverter\ParamConverterProviderInterface[]
     */
    protected $providers = array();

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     */
    public function onKernelController($event)
    {
        $request = $event->getRequest();
        $controller = $event->getController();
        $controllerClass = get_class($controller[0]);
        $methodName = $controller[1];

        $reflectedControllerClass = new \ReflectionClass($controllerClass);
        $reflectedMethod = $reflectedControllerClass->getMethod($methodName);

        foreach ($reflectedMethod->getParameters() as $reflectedParameter) {
            if ($request->attributes->has($reflectedParameter->getName())) {
                $value = $request->attributes->get($reflectedParameter->getName());

                foreach ($this->providers as $provider) {
                    if ($provider->supports($controller, $reflectedParameter, $value)) {
                        $value = $provider->convert($controller, $reflectedParameter, $value);
                    }
                }
                $request->attributes->set($reflectedParameter->getName(), $value);
            }
        }
    }

    /**
     * @param \Bongers\ElsBundle\ParamConverter\ParamConverterProviderInterface $provider
     *
     * @return ParamConverterListener
     */
    public function addProvider($provider)
    {
        $this->providers[] = $provider;

        return $this;
    }


}
