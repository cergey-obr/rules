<?php

namespace App\Model;

use App\Exceptions\StopProcessingException;

class Action extends AbstractModel
{
    /**
     * @return bool
     * @throws StopProcessingException
     */
    public function execute(): bool
    {
        if ($this->isStopProcessing()) {
            throw new StopProcessingException('Stop');
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isStopProcessing(): bool
    {
        return false;
    }
}
