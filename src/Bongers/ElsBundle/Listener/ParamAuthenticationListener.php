<?php
namespace Bongers\ElsBundle\Listener;

use Bongers\ElsBundle\Security\Privileges;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ParamAuthenticationListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function onKernelController($event)
    {
        $request = $event->getRequest();

        foreach ($request->attributes as $parameter) {
            if ($this->isObject($parameter)
                && !$this->getSecurityContext()->isGranted(Privileges::OBJECT_READ, $parameter)
            ) {
                throw new AccessDeniedException();
            }
        }
    }

    /**
     * @param mixed $parameter
     *
     * @return bool
     */
    public function isObject($parameter)
    {
        return is_object($parameter);
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext()
    {
        return $this->container->get('security.context');
    }
}
