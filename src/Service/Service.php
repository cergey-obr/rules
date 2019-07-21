<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\Rule;
use App\Entity\Combination;
use App\Entity\Condition;
use App\Repository\CombinationRepository;
use App\Repository\ConditionRepository;
use App\Repository\RuleRepository;
use App\Repository\ActionRepository;
use App\Exceptions\DbErrorException;

class Service
{
    /**
     * @var \stdClass
     */
    private $object;

    /**
     * @var RuleRepository
     */
    private $ruleRepository;

    /**
     * @var ActionRepository
     */
    private $actionRepository;

    /**
     * @var CombinationRepository
     */
    private $combinationRepository;

    /**
     * @var ConditionRepository
     */
    private $conditionRepository;

    /**
     * @param RuleRepository $ruleRepository
     * @param ActionRepository $actionRepository
     * @param CombinationRepository $combinationRepository
     * @param ConditionRepository $conditionRepository
     */
    public function __construct(
        RuleRepository $ruleRepository,
        ActionRepository $actionRepository,
        CombinationRepository $combinationRepository,
        ConditionRepository $conditionRepository
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->actionRepository = $actionRepository;
        $this->combinationRepository = $combinationRepository;
        $this->conditionRepository = $conditionRepository;
    }

    /**
     * @param string $target
     * @param \stdClass $object
     */
    public function applyRules(string $target, \stdClass $object): void
    {
        $this->object = $object;

        try {
            /** @var Rule $rule */
            foreach ($this->ruleRepository->getAvailableRules($target) as $rule) {
                /** @var Action $action */
                $action = $this->actionRepository->find($rule->getActionId());
                if (!$action->getId()) {
                    throw new \Exception("Action for {$rule->getId()} not found");
                }

                /** @var Combination $combination */
                $combination = $this->combinationRepository->find($rule->getCombinationId());
                if (!$combinationId = $combination->getId()) {
                    throw new \Exception("Combination for {$rule->getId()} not found");
                }

                $this->checkCombination($combination);
                $this->executeAction($action);
            }
        } catch (\Exception $e) {

        }
    }

    /**
     * @param Combination $combination
     *
     * @return bool
     * @throws DbErrorException
     * @throws \Exception
     */
    protected function checkCombination(Combination $combination): bool
    {
        $combinationId = $combination->getId();

        /** @var Condition $condition */
        foreach ($this->conditionRepository->findAll($combinationId) as $condition) {
            $isValidCondition = $this->checkCondition($condition);

            if ($combination->getAggregator() === 'all' && $combination->getValue() !== $isValidCondition) {
                throw new \Exception("All aggregator error");
            }

            if ($combination->getAggregator() === 'any' && $combination->getValue() === $isValidCondition) {
                break;
            }
        }

        /** @var Combination $childCombination */
        $childCombination = $this->combinationRepository->find($combinationId, 'parent_id');
        if ($childCombination->getId()) {
            $this->checkCombination($childCombination);
        }

        return true;
    }

    /**
     * @param Condition $condition
     *
     * @return bool
     */
    protected function checkCondition(Condition $condition): bool
    {
        return true;
    }

    /**
     * @param Action $action
     */
    protected function executeAction(Action $action)
    {

    }
}
