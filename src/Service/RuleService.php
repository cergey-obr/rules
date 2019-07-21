<?php

namespace App\Service;

use App\Model\Rule;
use App\Repository\RuleRepository;
use App\Repository\ActionRepository;

class RuleService
{
    private $ruleRepository;

    private $actionRepository;

    /**
     * @param RuleRepository $ruleRepository
     * @param ActionRepository $actionRepository
     */
    public function __construct(RuleRepository $ruleRepository, ActionRepository $actionRepository)
    {
        $this->ruleRepository = $ruleRepository;
        $this->actionRepository = $actionRepository;
    }

    /**
     * @param string $target
     * @param \stdClass $object
     */
    public function applyRules(string $target, \stdClass $object): void
    {
        try {
            /** @var Rule $rule */
            foreach ($this->ruleRepository->getAvailableRules($target) as $rule) {
                if ($rule->evaluate($object)) {
                    $action = $this->actionRepository->findById($rule->getActionId());
                    $action->execute();
                }
            }
        } catch (\Exception $e) {

        }
    }
}
