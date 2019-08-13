<?php

namespace Optimax\RuleBundle\Aggregators;

class AllAggregator extends AbstractAggregator implements AggregatorInterface
{
    /**
     * @param bool|array $result
     *
     * @throws \Exception
     */
    public function check($result)
    {
        $array = (array)$result;

        foreach ($array as $item) {
            if ($item !== $this->value) {
                throw new \Exception('Result not suitable for all aggregator');
            }
        }
    }
}
