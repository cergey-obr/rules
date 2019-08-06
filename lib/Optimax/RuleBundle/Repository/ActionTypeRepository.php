<?php

namespace Optimax\RuleBundle\Repository;

use Optimax\RuleBundle\Entity\ActionType;

class ActionTypeRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'action_type';
    }

    protected function getModelClass(): string
    {
        return ActionType::class;
    }
}
