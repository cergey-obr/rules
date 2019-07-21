<?php

namespace App\Service;

use App\Model\Rule;
use App\Exceptions\DbErrorException;

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
            /** @var Rule $rule */
            foreach ($this->getRules($target) as $rule) {
                $rule->dbService = $this->dbService;
                if ($rule->evaluate($object)) {
                    $rule->getAction()->execute();
                }
            }
        } catch (\Exception $e) {

        }
    }

    /**
     * Get available rules by target
     *
     * @param string $target
     *
     * @return \Generator
     * @throws DbErrorException
     */
    private function getRules(string $target): \Generator
    {
        $sql = "SELECT * FROM rules.rule WHERE target = '%s' 
            AND (date_from is null or date_from <= '%s') 
            AND (date_to is null or date_to >= '%s') 
            AND active = true 
        ORDER BY priority DESC";

        $result = $this->dbService->execute(sprintf($sql, $target, $now = date('Y-m-d'), $now));
        while ($rule = $result->fetch_object(Rule::class)) {
            yield $rule;
        }
    }
}
