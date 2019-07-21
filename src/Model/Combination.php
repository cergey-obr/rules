<?php

namespace App\Model;

use App\Exceptions\DbErrorException;

class Combination extends AbstractModel
{
    /**
     * @param \stdClass $object
     *
     * @return bool
     * @throws DbErrorException
     */
    public function check(\stdClass $object): bool
    {
        /** @var Condition $condition */
        foreach ($this->getConditions() as $condition) {
            $condition->check($object);
        }

        return true;
    }

    /**
     * @return \Generator
     * @throws DbErrorException
     */
    private function getConditions(): \Generator
    {
        $sql = "SELECT * FROM rules.condition WHERE combination_id = '%s'";
        $result = $this->dbService->execute(sprintf($sql, $this->id));
        while ($condition = $result->fetch_object(Condition::class)) {
            yield $condition;
        }
    }
}
