<?php

namespace App\RuleActions;

use Optimax\RuleBundle\RuleActions\ActionInterface;

class PercentAction implements ActionInterface
{
    public function execute(&$object): void
    {
        $object->price = 100;
    }
}
