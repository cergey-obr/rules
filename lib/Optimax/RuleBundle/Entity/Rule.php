<?php

namespace Optimax\RuleBundle\Entity;

use Symfony\Component\HttpFoundation\Request;

class Rule extends AbstractCombination
{
    /**
     * @var int
     */
    private $action_id;

    /**
     * @var int
     */
    private $combination_id;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $target;

    /**
     * @var \DateTime|null
     */
    private $date_from;

    /**
     * @var \DateTime|null
     */
    private $date_to;

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
     * @return Action
     * @throws \Exception
     */
    public function getAction(): Action
    {
        /** @var Action $action */
        $action = $this->entityManager
            ->getRepository('action')
            ->find($this->action_id);

        if (!$action) {
            throw new \Exception("Action for rule (id: {$this->id}) not found");
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
        $date = $this->date_from;
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
        $date = $this->date_to;
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
     * @param Request $request
     *
     * @throws \Exception
     */
    public function check($object, $subject, Request $request): void
    {
        /** @var Combination $combination */
        if (!$combination = $this->getCombinationById($this->combination_id)) {
            throw new \Exception("Combination for rule (id: {$this->id}) not found");
        }

        $combination->check($object, $subject, $request);
    }
}
