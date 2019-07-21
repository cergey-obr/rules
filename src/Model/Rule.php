<?php

namespace App\Model;

use stdClass;
use App\Exceptions\DbErrorException;

class Rule extends AbstractModel
{
    /**
     * @var integer
     */
    private $action_id;

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
     * @return int
     */
    public function getActionId(): int
    {
        return (int)$this->action_id;
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
