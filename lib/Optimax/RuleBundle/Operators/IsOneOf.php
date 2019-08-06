<?php

namespace Optimax\RuleBundle\Operators;

class IsOneOf extends AbstractOperator implements OperatorInterface
{
    /**
     * @inheritDoc
     */
    public function compare($attributeValue, string $value): bool
    {
        $values = explode(',', $value);

        if (is_array($attributeValue)) {
            return count(array_intersect($attributeValue, $values)) > 0;
        }

        foreach ($values as $value) {
            if ($this->compareValues((string)$attributeValue, (string)$value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $validatedValue
     * @param string $value
     *
     * @return bool
     */
    private function compareValues(string $validatedValue, string $value): bool
    {
        $validatePattern = preg_quote($validatedValue, '~');
        return (bool)preg_match('~^' . $validatePattern . '$~iu', $value);
    }
}
