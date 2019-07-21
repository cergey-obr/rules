<?php

namespace App\Entity;

class Rule extends AbstractEntity
{
    /**
     * @var integer
     */
    private $action_id;

    /**
     * @var integer
     */
    private $combination_id;

    /**
     * @return int
     */
    public function getActionId(): int
    {
        return (int)$this->action_id;
    }

    /**
     * @return int
     */
    public function getCombinationId(): int
    {
        return (int)$this->combination_id;
    }
}
