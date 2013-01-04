<?php
namespace Bongers\ElsBundle\Repository;

class ResultQueryBuilder
{
    protected $repository;

    public function getQueryBuilder()
    {

    }

    public function applyAclMask($mask)
    {
        $allowedQueryBuilder = $this->repository->getAllowedQueryBuilder($mask);
        $alias = $this->repository->getAlias();
        $identifier = $this->repository->getIdentifier();
        $this
            ->getQueryBuilder()
            ->andWhere($alias . '.' . $identifier . ' IN (' . $allowedQueryBuilder . ')' );

    }

    public function applyLimitAndOffset($limit, $offset = 0)
    {

    }

    public function getResult()
    {

    }

    public function getOneOrNullResult()
    {

    }

    public function getSingleScalarResult()
    {

    }

    public function selectIds()
    {

    }

    public function getIds()
    {

    }

    public function getId()
    {
        return return reset($this->getIds());
    }
}
