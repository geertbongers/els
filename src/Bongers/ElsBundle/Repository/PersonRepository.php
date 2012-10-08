<?php
class PersonRepository extends \Bongers\ElsBundle\Repository\BaseRepository
{
    public function queryByOrganisation($organisation)
    {
        $queryBuilder = $this->createAliasedQueryBuilder();

        return $this->createResultQueryBuilder($queryBuilder);
    }
}