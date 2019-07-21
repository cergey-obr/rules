<?php

namespace App\Entity;

class Action extends AbstractEntity
{
    /**
     * @var bool
     */
    private $stop_processing;

    /**
     * @return bool
     */
    public function isStopProcessing(): bool
    {
        return (bool)$this->stop_processing;
    }
}
