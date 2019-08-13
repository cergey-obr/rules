<?php

namespace Optimax\RuleBundle\Aggregators;

use Optimax\RuleBundle\Exceptions\AnyAggregatorException;

class AnyAggregator extends AbstractAggregator implements AggregatorInterface
{
    /**
     * @param bool|array $result
     *
     * @return true
     * @throws AnyAggregatorException
     */
    public function check($result)
    {
        $array = (array)$result;

        foreach ($array as $item) {
            if ($item === $this->value) {
                return true;
            }
        }

        throw new AnyAggregatorException('Result not suitable for any aggregator');
    }
}
