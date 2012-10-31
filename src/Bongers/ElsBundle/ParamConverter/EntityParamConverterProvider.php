<?php
namespace Bongers\ElsBundle\ParamConverter;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 *
 */
class EntityParamConverterProvider implements ParamConverterProviderInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

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
     *
     * @return bool
     */
    public function supports($controller, $reflectedParameter, $value)
    {
        $class= $reflectedParameter->getClass();

        if (!empty($class)) {
            $metadata = $this->entityManager->getClassMetadata($class);

            return $metadata instanceof ClassMetadata;
        }

        return false;
    }

    /**
     * @param                      $controller
     * @param \ReflectionParameter $reflectedParameter
     * @param mixed                $value
     *
     * @return mixed|void
     */
    public function convert($controller, $reflectedParameter, $value)
    {
        $metadata = $this->entityManager->getClassMetadata($reflectedParameter->getClass());
        $repository = $this->entityManager->getRepository($metadata->getName());

        return $repository->find($value);
    }
}