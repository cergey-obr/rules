<?php

namespace Optimax\RuleBundle\Operators;

class GreaterThan extends LessThanOrEqual
{
    protected $inverse = true;
}
