<?php

namespace Optimax\RuleBundle\Repository;

use Optimax\RuleBundle\Entity\Condition;

class ConditionRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'condition';
    }

    protected function getModelClass(): string
    {
        return Condition::class;
    }
}
