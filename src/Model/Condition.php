<?php

namespace App\Model;

class Condition extends AbstractModel
{
    public function check(\stdClass $object): bool
    {
        return true;
    }
}
