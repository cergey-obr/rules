<?php

namespace App\Repository;

use App\Model\Rule;
use App\Exceptions\DbErrorException;

class RuleRepository extends AbstractRepository
{
    protected $table = 'rule';
    protected $model = Rule::class;

    /**
     * @param string $target
     *
     * @return \Generator
     * @throws DbErrorException
     * @throws \Exception
     */
    public function getAvailableRules(string $target): \Generator
    {
        $sql = "SELECT * FROM {$this->table} WHERE target = '%s' 
            AND (date_from is null or date_from <= '%s') 
            AND (date_to is null or date_to >= '%s') 
            AND active = true 
        ORDER BY priority DESC";

        $result = $this->dbService->getConnection()->execute(sprintf($sql, $target, $now = date('Y-m-d'), $now));
        while ($rule = $result->fetch_object(Rule::class)) {
            yield $rule;
        }
    }
}
