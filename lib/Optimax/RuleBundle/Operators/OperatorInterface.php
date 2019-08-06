<?php

namespace Optimax\RuleBundle\Operators;

interface OperatorInterface
{
    /**
     * @param mixed $attributeValue
     * @param string $value
     *
     * @return bool
     */
    public function compare($attributeValue, string $value): bool;

    /**
     * @return bool
     */
    public function isInverse(): bool;
}
