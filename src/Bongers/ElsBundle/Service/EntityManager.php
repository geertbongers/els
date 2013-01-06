<?php
use Bongers\ElsBundle\Service;

use Doctrine\ORM\EntityManager as DoctrineEntityManager;

class EntityManager extends DoctrineEntityManager
{
    CONST SCHEDULED_FOR_DELETE = 'scheduledForDelete';
    CONST SCHEDULED_FOR_UPDATE = 'scheduledForUpdate';
    CONST SCHEDULED_FOR_INSERT = 'scheduledForInsert';

    protected $entityStatus;


    public function setEntityStatus($entity, $scheduledFor)
    {
        $this->getUnitOfWork()->getEntityIdentifier($entity);
        $idHash = implode(' ', $this->getUnitOfWork()->getEntityIdentifier($entity));

        $currentStatus = $this->entityStatus[get_class($entity)][$idHash];

        if ($currentStatus == self::SCHEDULED_FOR_DELETE) {

        } elseif ($currentStatus == self::SCHEDULED_FOR_UPDATE) {

        }
        $this->entityStatus[get_class($entity)][$idHash] = $scheduledFor;
    }

    public function getEntityStatus($entity)
    {
    }

    public function hasStatus($status)
    {

    }
}
