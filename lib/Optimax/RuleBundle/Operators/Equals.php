<?php

namespace Optimax\RuleBundle\Operators;

class Equals extends AbstractOperator implements OperatorInterface
{
    /**
     * @inheritDoc
     */
    public function compare($attributeValue, string $value): bool
    {
        if (is_array($attributeValue) && $values = explode(',', $value)) {
            return !count(array_diff($values, $attributeValue));
        }

        return $attributeValue == $value;
    }
}
