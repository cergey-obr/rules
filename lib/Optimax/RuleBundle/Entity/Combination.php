<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\Aggregators\AggregatorInterface;
use Optimax\RuleBundle\Aggregators\AnyAggregator;
use Optimax\RuleBundle\Environment\AbstractEnvironment;
use Optimax\RuleBundle\Exceptions\AnyAggregatorException;

class Combination extends AbstractCombination
{
    /**
     * @var string
     */
    private $aggregator;

    /**
     * @var bool
     */
    private $value;

    /**
     * @param bool $value
     *
     * @return AggregatorInterface
     * @throws \Exception
     */
    public function getAggregator(bool $value): AggregatorInterface
    {
        $className = 'Optimax\RuleBundle\Aggregators\\' . ucfirst($this->aggregator) . 'Aggregator';
        if (!class_exists($className)) {
            throw new \Exception("Aggregator {$this->aggregator} not implemented");
        }

        return new $className($value);
    }

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param AbstractEnvironment $environment
     *
     * @throws \Exception
     */
    public function check($object, $subject, AbstractEnvironment $environment): void
    {
        $combinationValue = (bool)$this->value;
        $aggregator = $this->getAggregator($combinationValue);

        try {
            $this->validateConditions($object, $subject, $environment, $aggregator);
            $checkResults[] = $combinationValue;
        } catch (AnyAggregatorException $e) {
            $checkResults[] = !$combinationValue;
        }

        $childCombinations = $this->entityManager
            ->getRepository('combination')
            ->findAll($this->id, 'parentId');

        /** @var Combination $childCombination */
        foreach ($childCombinations as $childCombination) {
            try {
                $childCombination->check($object, $subject, $environment);
                $checkResults[] = true;
            } catch (\Exception $e) {
                $checkResults[] = false;
            }
        }

        $aggregator->check($checkResults);
    }

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param AbstractEnvironment $environment
     * @param AggregatorInterface $aggregator
     *
     * @throws \Exception
     * @throws AnyAggregatorException
     * @throws \Doctrine\DBAL\DBALException
     */
    private function validateConditions(
        $object,
        $subject,
        AbstractEnvironment $environment,
        AggregatorInterface $aggregator
    ): void {
        $isValid = false;

        $conditions = $this->entityManager
            ->getRepository('condition')
            ->findAll($this->id, 'combinationId');

        /** @var Condition $condition */
        foreach ($conditions as $condition) {
            $isValidCondition = $condition->isValid($object, $subject, $environment);

            try {
                if ($aggregator->check($isValidCondition)) {
                    $isValid = true;
                    break;
                }
            } catch (AnyAggregatorException $e) {
                continue;
            }
        }

        if ($aggregator instanceof AnyAggregator && !$isValid) {
            throw new AnyAggregatorException('Combination of conditions failed validation');
        }
    }
}
