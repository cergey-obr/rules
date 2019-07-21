<?php

namespace App\Entity;

class Condition extends AbstractEntity
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return (string)$this->attribute;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return (string)$this->operator;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return (string)$this->value;
    }

}
