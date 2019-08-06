<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\Service\EntityManager;

abstract class AbstractEntity
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var int
     */
    protected $id;

    /**
     * @param EntityManager $entityManager
     *
     * @throws \Exception
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }
}
