<?php

namespace App\Entity;

class Combination extends AbstractEntity
{
    /**
     * @var string
     */
    private $aggregator;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var bool
     */
    private $value;

    /**
     * @return string
     */
    public function getAggregator(): string
    {
        return (string)$this->aggregator;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return (string)$this->operator;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return (bool)$this->value;
    }
}
