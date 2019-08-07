<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\RuleActions\ActionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Action extends AbstractCombination
{
    /**
     * @var int
     */
    private $type_id;

    /**
     * @var int
     */
    private $combination_id;

    /**
     * @var bool
     */
    private $stop_processing;

    /**
     * @return ActionType|null
     * @throws \Exception
     */
    public function getType(): ?ActionType
    {
        /** @var ActionType $actionType */
        $actionType = $this->entityManager
            ->getRepository('actionType')
            ->find($this->type_id);

        return $actionType;
    }

    /**
     * @return Combination|null
     * @throws \Exception
     */
    public function getCombination(): ?Combination
    {
        return $this->getCombinationById($this->combination_id);
    }

    /**
     * @return bool
     */
    public function isStopProcessing(): bool
    {
        return (bool)$this->stop_processing;
    }

    public function load(ParameterBagInterface $params): ActionInterface
    {
        $className = $params->get('optimax_rule.namespace') . '\PercentAction';
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Undefined action");
        }

        return new $className();
    }
}
