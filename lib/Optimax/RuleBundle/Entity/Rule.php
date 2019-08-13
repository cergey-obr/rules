<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\Environment\AbstractEnvironment;
use Optimax\RuleBundle\Exceptions\CheckRuleException;

class Rule extends AbstractCombination
{
    /**
     * @var int
     */
    private $actionId;

    /**
     * @var int
     */
    private $combinationId;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $target;

    /**
     * @var string|null
     */
    private $dateFrom;

    /**
     * @var string|null
     */
    private $dateTo;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $priority;

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param AbstractEnvironment $environment
     *
     * @return Action
     * @throws \Exception
     * @throws CheckRuleException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAction($object, $subject, AbstractEnvironment $environment): Action
    {
        /** @var Action|null $action */
        $action = $this->entityManager
            ->getRepository('action')
            ->find($this->actionId);

        if (!$action) {
            throw new \Exception("Action for rule (id: {$this->id}) not found");
        }

        if ($combination = $action->getCombination()) {
            try {
                $combination->check($object, $subject, $environment);
            } catch (\Exception $e) {
                throw new CheckRuleException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return $action;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool)$this->active;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFrom(): ?\DateTime
    {
        $date = $this->dateFrom;
        try {
            return $date ? new \DateTime($date) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getDateTo(): ?\DateTime
    {
        $date = $this->dateTo;
        try {
            return $date ? new \DateTime($date) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param AbstractEnvironment $environment
     *
     * @throws CheckRuleException
     */
    public function check($object, $subject, AbstractEnvironment $environment): void
    {
        /** @var Combination $combination */
        if (!$combination = $this->getCombinationById($this->combinationId)) {
            throw new CheckRuleException("Combination for rule (id: {$this->id}) not found");
        }

        try {
            $combination->check($object, $subject, $environment);
        } catch (\Exception $e) {
            throw new CheckRuleException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
