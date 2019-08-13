<?php

namespace Optimax\RuleBundle\Aggregators;

use Optimax\RuleBundle\Exceptions\AnyAggregatorException;

interface AggregatorInterface
{
    /**
     * @param bool|array $result
     *
     * @return mixed
     * @throws AnyAggregatorException
     * @throws \Exception
     */
    public function check($result);
}
