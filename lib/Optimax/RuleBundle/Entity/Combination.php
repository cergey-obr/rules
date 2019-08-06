<?php

namespace Optimax\RuleBundle\Entity;

use Symfony\Component\HttpFoundation\Request;

class Combination extends AbstractCombination
{
    /**
     * @var string
     */
    private $aggregator;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var bool
     */
    private $value;

    /**
     * @return string
     */
    public function getAggregator(): string
    {
        return $this->aggregator;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return (bool)$this->value;
    }

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param Request $request
     *
     * @throws \Exception
     */
    public function check($object, $subject, Request $request): void
    {
        $conditions = $this->entityManager
            ->getRepository('condition')
            ->findAll($this->id, 'combination_id');

        /** @var Condition $condition */
        foreach ($conditions as $condition) {
            $isValid = $condition->isValid($object, $subject, $request);

            if ($this->aggregator == 'all' && $isValid != $this->getValue()) {
                throw new \Exception('Check combination is failed');
            }

            if ($this->aggregator == 'any' && $isValid == $this->getValue()) {
                break;
            }
        }

        $childCombinations = $this->entityManager
            ->getRepository('combination')
            ->findAll($this->id, 'parent_id');

        /** @var Combination $childCombination */
        foreach ($childCombinations as $childCombination) {
            $childCombination->check($object, $subject, $request);
        }
    }
}
