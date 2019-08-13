<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\RuleActions\ActionInterface;

class Action extends AbstractCombination
{
    /**
     * @var int
     */
    private $typeId;

    /**
     * @var int
     */
    private $combinationId;

    /**
     * @var bool
     */
    private $stopProcessing;

    /**
     * @return ActionType
     * @throws \Exception
     */
    public function getType(): ActionType
    {
        /** @var ActionType|null $actionType */
        $actionType = $this->entityManager
            ->getRepository('actionType')
            ->find($this->typeId);

        if (!$actionType) {
            throw new \Exception('Action type not found');
        }

        return $actionType;
    }

    /**
     * @return Combination|null
     * @throws \Exception
     */
    public function getCombination(): ?Combination
    {
        return $this->combinationId ? $this->getCombinationById($this->combinationId) : null;
    }

    /**
     * @return bool
     */
    public function isStopProcessing(): bool
    {
        return (bool)$this->stopProcessing;
    }

    /**
     * @param string $namespace
     *
     * @return ActionInterface
     * @throws \Exception
     */
    public function load(string $namespace): ActionInterface
    {
        $code = str_replace('_', '', ucwords($this->getType()->getCode(), '_'));
        $className = $namespace . '\\' . $code . 'Action';
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Undefined action $className");
        }

        return new $className();
    }
}
