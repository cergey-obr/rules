<?php

namespace App\Model;

use App\Exceptions\DbErrorException;

class Rule extends AbstractModel
{
    /**
     * @var integer
     */
    protected $action_id;

    /**
     * @param \stdClass $object
     *
     * @return bool
     * @throws DbErrorException
     */
    public function evaluate(\stdClass $object): bool
    {
        $combination = $this->getCombination();
        $combination->dbService = $this->dbService;

        return $combination->check($object);
    }

    /**
     * @return Action
     * @throws DbErrorException
     */
    public function getAction(): Action
    {
        $sql = "SELECT * FROM rules.action WHERE id = '%s'";
        $result = $this->dbService->execute(sprintf($sql, $this->action_id));

        /** @var Action $action */
        $action = $result->fetch_object(Action::class);
        return $action;
    }

    /**
     * @return Combination
     * @throws DbErrorException
     */
    private function getCombination(): Combination
    {
        $sql = "SELECT * FROM rules.combination WHERE id = '%s'";
        $result = $this->dbService->execute(sprintf($sql, $this->id));

        /** @var Combination $combination */
        $combination = $result->fetch_object(Combination::class);
        return $combination;
    }
}
