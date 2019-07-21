<?php

namespace App\Model;

use stdClass;
use App\Exceptions\DbErrorException;
use App\Repository\ActionRepository;

class Rule extends AbstractModel
{
    /**
     * @var integer
     */
    protected $action_id;

    /**
     * @param stdClass $object
     *
     * @return bool
     */
    public function evaluate(stdClass $object): bool
    {
        return true;

        /*$combination = $this->getCombination();
        $combination->dbService = $this->dbService;

        return $combination->check($object);*/
    }

    /**
     * @return Action
     * @throws DbErrorException
     */
    public function getAction(): Action
    {
        /** @var Action $action */
        $action = (new ActionRepository())->findById($this->action_id, Action::class);
        return $action;
    }

    /**
     * @return Combination
     * @throws DbErrorException
     */
    /*private function getCombination(): Combination
    {
        $sql = "SELECT * FROM rules.combination WHERE id = '%s'";
        $result = $this->dbService->execute(sprintf($sql, $this->id));

        $combination = $result->fetch_object(Combination::class);
        return $combination;
    }*/
}
