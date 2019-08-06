<?php

namespace Optimax\RuleBundle\Operators;

class LessThan extends GreaterThanOrEqual
{
    protected $inverse = true;
}
