<?php

namespace Optimax\RuleBundle\Operators;

class Contains extends AbstractOperator implements OperatorInterface
{
    /**
     * @inheritDoc
     */
    public function compare($attributeValue, $value): bool
    {
        $values = explode(',', $value);

        if (is_scalar($attributeValue)) {
            foreach ($values as $value) {
                if (stripos((string)$attributeValue, (string)$value) === false) {
                    return false;
                }
            }

            return true;
        } elseif (is_array($attributeValue)) {
            return count(array_intersect($values, $attributeValue)) === count($values);
        }

        throw new \LogicException('Attribute value type unavailable for comparison with "contains" operator');
    }
}
