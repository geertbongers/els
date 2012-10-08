<?php
/**
 *
 *
 * @author geertbongers
 */
namespace Acme;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 *
 *
 * @category
 * @package     ResultSet
 * @subpackage  ResultSet
 * @copyright   Copyright (c) 2011 G.P. Bongers
 */
class ResultSet
{
    CONST ORDER_ASC = 'ASC';
    CONST ORDER_DESC = 'DESC';
    CONST ALIAS = 'alias';

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $classMetadata;
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;


    public function __construct($entityManager, $classMetadata, $repository)
    {

    }

    public function filterById($id)
    {
        $alias = self::ALIAS;
        $idField = $this->classMetadata->getIdentifier();

        $this
            ->getQueryBuilder()
            ->andWhere("$alias.$idField = :id")
            ->setParameter('id', $id);
    }

    public function filterByIds($ids)
    {
        $alias = self::ALIAS;
        $idField = $this->classMetadata->getIdentifier();

        $this
            ->getQueryBuilder()
            ->andWhere("$alias.$idField in (:ids)")
            ->setParameter('ids', $ids);
    }

    /**
     * Set queryBuilder
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @return ResultSet
     */
    public function setQueryBuilder($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        return $this;
    }

    /**
     * Get queryBuilder
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function filterByOrganisation($organisation)
    {

    }

    public function selectListFields()
    {

    }

    public function selectOrganisation()
    {

    }

    public function filterByAclAssignManager($manager)
    {
        $this->filterByMask(MaskBuilder::MASK_MASTER);
    }

    public function filterByMask()
    {

    }

    public function combineForAssignManager()
    {

    }

    public function orderByName($order = self::ORDER_ASC)
    {
        $alias = self::ALIAS;
        $this->getQueryBuilder()->orderBy("$alias.name = $order");
    }

    public function count()
    {

    }

    public function countWithoutLimit()
    {

    }


    public function getOneOrNull()
    {

    }

    public function getAll()
    {

    }

    public function getSingleScalarResult()
    {

    }
}