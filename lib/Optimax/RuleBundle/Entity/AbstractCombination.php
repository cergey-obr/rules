<?php

namespace Optimax\RuleBundle\Entity;

abstract class AbstractCombination extends AbstractEntity
{
    /**
     * @param int $combinationId
     *
     * @return Combination|null
     * @throws \Exception
     */
    public function getCombinationById(int $combinationId): ?Combination
    {
        /** @var Combination $combination */
        $combination = $this->entityManager
            ->getRepository('combination')
            ->find($combinationId);

        return $combination;
    }
}
