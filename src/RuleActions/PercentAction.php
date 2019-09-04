<?php

namespace App\RuleActions;

use Optimax\RuleBundle\RuleActions\AbstractAction;

class PercentAction extends AbstractAction
{
    public function execute(&$object): void
    {
        $object->price = 100;
    }
}
