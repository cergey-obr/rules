<?php

namespace App\Service;

use App\Model\Rule;
use App\Repository\RuleRepository;

class RuleService
{
    /**
     * @var DbService
     */
    private $dbService;

    /**
     * @param DbService $dbService
     */
    public function __construct(DbService $dbService)
    {
        $this->dbService = $dbService;
    }

    /**
     * @param string $target
     * @param \stdClass $object
     */
    public function applyRules(string $target, \stdClass $object): void
    {
        try {
            $ruleRepository = new RuleRepository($this->dbService);

            /** @var Rule $rule */
            foreach ($ruleRepository->getAvailableRules($target) as $rule) {
                if ($rule->evaluate($object)) {
                    $action = $rule->getAction();
                    //$action->execute();
                }
            }
        } catch (\Exception $e) {

        }
    }
}
