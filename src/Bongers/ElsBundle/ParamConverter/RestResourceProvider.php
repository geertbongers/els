<?php
namespace Bongers\ElsBundle\ParamConverter;

class RestResourceProvider
{

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param                      $controller
     * @param \ReflectionParameter $reflectedParameter
     * @param mixed                $value
     * @return bool
     */
    public function supports($controller, $reflectedParameter, $value)
    {
        return $controller instanceof \Bongers\ElsBundle\Controller\RestEntityController
            && $reflectedParameter->getClass() == 'RestResource';
    }


    /**
     * @param $controller
     * @param \ReflectionParameter $reflectedParameter
     * @param mixed $value
     *
     * @return object
     */
    public function convert($controller, $reflectedParameter, $value)
    {
        $metadata = $this->entityManager->getClassMetadata(
            get_class($controller->getRestResource())
        );
        $repository = $this->entityManager->getRepository($metadata->getName());

        return $repository->find($value);
    }
}
