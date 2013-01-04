<?php
class QueryObject
{
    public function from()
    {
        $queryBuilder = new PersonQuery();

        $queryBuilder
            ->joinOrganisation()
            ->where(
                $expr->firstName->equals('test')
                    ->and()->organsation->name->equals('ja')
                    ->and()->person->modified->isNotNull()
            );

        $queryBuilder->getQuery();
    }
}
