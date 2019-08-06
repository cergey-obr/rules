<?php

namespace Optimax\RuleBundle\Operators;

class AbstractOperator
{
    /**
     * @var bool
     */
    protected $inverse = false;

    /**
     * @return bool
     */
    public function isInverse(): bool
    {
        return $this->inverse;
    }

    /**
     * @param mixed $value
     */
    protected function checkScalar($value): void
    {
        if (!is_scalar($value)) {
            $type = gettype($value);
            throw new \LogicException("Value isn't scalar, it is {$type}");
        }
    }
}
