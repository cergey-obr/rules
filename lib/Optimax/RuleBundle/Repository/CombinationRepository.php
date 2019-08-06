<?php

namespace Optimax\RuleBundle\Repository;

use Optimax\RuleBundle\Entity\Combination;

class CombinationRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'combination';
    }

    protected function getModelClass(): string
    {
        return Combination::class;
    }
}
