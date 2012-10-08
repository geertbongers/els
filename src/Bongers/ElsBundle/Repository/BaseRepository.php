<?php
namespace Bongers\ElsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    const ALIAS = 'alias';

    protected $queryBuilder = null;

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createAliasedQueryBuilder()
    {
        return $this->createQueryBuilder(self::ALIAS);
    }

    /**
     * @param $queryBuilder
     *
     * @return EntityCollection
     */
    protected function createResultQueryBuilder($queryBuilder)
    {
        return new EntityCollection($this, $queryBuilder);
    }

    public function getAllowedQueryBuilder($mask)
    {
    }
}