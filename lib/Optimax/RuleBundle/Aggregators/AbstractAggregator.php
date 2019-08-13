<?php

namespace Optimax\RuleBundle\Aggregators;

abstract class AbstractAggregator
{
    /**
     * @var bool
     */
    protected $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }
}
