<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\RuleActions\ActionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class Rule extends AbstractCombination
{
    /**
     * @var mixed
     */
    private $object;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var Request
     */
    private $request;

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
     * @param mixed $object
     *
     * @return Rule
     */
    public function setObject($object): self
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @param $subject
     *
     * @return Rule
     */
    public function setSubject($subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return Rule
     */
    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param ParameterBagInterface $params
     *
     * @return ActionInterface
     * @throws \Exception
     */
    public function getAction(ParameterBagInterface $params): ActionInterface
    {
        /** @var Action $action */
        $action = $this->entityManager
            ->getRepository('action')
            ->find($this->action_id);

        if (!$action) {
            throw new \Exception("Action for rule (id: {$this->id}) not found");
        }

        /*if ($combination = $action->getCombination()) {
            $combination->check($this->object, $this->subject, $this->request);
        }*/

        return $action->load($params);
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
     * @throws \Exception
     */
    public function check(): void
    {
        /** @var Combination $combination */
        if (!$combination = $this->getCombinationById($this->combination_id)) {
            throw new \Exception("Combination for rule (id: {$this->id}) not found");
        }

        $combination->check($this->object, $this->subject, $this->request);
    }
}
