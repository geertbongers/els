<?php
namespace Bongers\ElsBundle\Repository;

class EntityCollection
{
    protected $repository;

    public function getQueryBuilder()
    {

    }

    public function filterByAclMask($mask)
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

    public function getEntities()
    {

    }

    public function getEntity()
    {

    }

    public function getSingleScalarResult()
    {

    }

    public function filterById($id)
    {

    }

    public function filterByIds()
    {

    }

    public function select()
    {

    }

    public function selectDetails()
    {

    }

    public function selectList()
    {

    }

    public function selectDetailsAndFilterById($id)
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
        return reset($this->getIds());
    }
}
