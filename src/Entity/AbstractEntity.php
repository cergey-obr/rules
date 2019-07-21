<?php

namespace App\Entity;

abstract class AbstractEntity
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }
}
