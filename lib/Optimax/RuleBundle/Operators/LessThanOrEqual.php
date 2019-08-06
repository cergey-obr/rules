<?php

namespace Optimax\RuleBundle\Operators;

class LessThanOrEqual extends AbstractOperator implements OperatorInterface
{
    /**
     * @inheritDoc
     */
    public function compare($attributeValue, string $value): bool
    {
        $this->checkScalar($attributeValue);
        return $attributeValue <= $value;
    }
}
