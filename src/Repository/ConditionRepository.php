<?php

namespace App\Repository;

use App\Entity\Condition;
use App\Exceptions\DbErrorException;

class ConditionRepository extends AbstractRepository
{
    protected $table = 'condition';
    protected $model = Condition::class;

    /**
     * @param int $combinationId
     *
     * @return \Generator
     * @throws DbErrorException
     */
    public function findAll(int $combinationId): \Generator
    {
        $result = $this->dbService->execute("SELECT * FROM {$this->table} WHERE combination_id = '{$combinationId}'");
        while ($condition = $result->fetch_object($this->model)) {
            yield $condition;
        }
    }
}
