<?php

namespace Optimax\RuleBundle\RuleActions;

interface ActionInterface
{
    /**
     * @param mixed $object
     */
    public function execute(&$object): void;
}
