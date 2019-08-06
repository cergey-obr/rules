<?php

namespace Optimax\RuleBundle\Repository;

use Optimax\RuleBundle\Entity\Action;

class ActionRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'action';
    }

    protected function getModelClass(): string
    {
        return Action::class;
    }
}
