<?php

namespace Optimax\RuleBundle\Service;

use Optimax\RuleBundle\Operators\OperatorInterface;

class ConditionService
{
    /**
     * @param string $operatorCode
     * @param mixed $attributeValue
     * @param string $value
     *
     * @return bool
     * @throws \LogicException
     */
    public function check(string $operatorCode, $attributeValue, string $value): bool
    {
        $operator = $this->getOperator($operatorCode);
        $result = $operator->compare($attributeValue, $value);

        return $operator->isInverse() ? !$result : $result;
    }

    /**
     * @param string $code
     *
     * @return OperatorInterface
     * @throws \InvalidArgumentException
     */
    private function getOperator(string $code): OperatorInterface
    {
        $code = str_replace(' ', '', ucwords($code));
        $className = 'Optimax\RuleBundle\Operators\\' . $code;
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Unknown condition operator code: {$code}");
        }

        return new $className();
    }
}
