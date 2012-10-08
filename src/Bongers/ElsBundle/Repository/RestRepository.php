<?php
abstract class RestRepository
{
    public function createQueryBuilder($alias)
    {
        $queryBuilder = parent::createQueryBuilder($alias)
            ->addSelect('u, a, o')
            ->join('p.user', 'u')
            ->join('p.address', 'a')
            ->join('p.organisaton', 'o');

        return $queryBuilder;
    }
}
