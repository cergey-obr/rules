<?php

namespace Optimax\RuleBundle\Repository;

use Doctrine\DBAL\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\DBALException;
use Optimax\RuleBundle\Service\EntityManager;
use Optimax\RuleBundle\Entity\AbstractEntity;

abstract class AbstractRepository
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param EntityManager $entityManager
     *
     * @throws \Exception
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    /**
     * @param int $value
     * @param string $field
     *
     * @return AbstractEntity|null
     * @throws DBALException
     */
    public function find(int $value, string $field = 'id'): ?AbstractEntity
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE {$field} = ? LIMIT 1";

        /** @var Statement $statement */
        $statement = $this->connection->executeQuery($sql, [$value], [ParameterType::INTEGER]);
        $statement->setFetchMode(FetchMode::CUSTOM_OBJECT, $this->getModelClass(), [$this->entityManager]);

        /** @var AbstractEntity $object */
        $object = $statement->fetch();
        $statement->closeCursor();

        if ($object instanceof AbstractEntity) {
            return $object;
        }

        return null;
    }

    /**
     * @param int $value
     * @param string $field
     *
     * @return \Generator
     * @throws DBALException
     */
    public function findAll(int $value, string $field): \Generator
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE {$field} = ?";

        /** @var Statement $statement */
        $statement = $this->connection->executeQuery($sql, [$value], [ParameterType::INTEGER]);
        $statement->setFetchMode(FetchMode::CUSTOM_OBJECT, $this->getModelClass(), [$this->entityManager]);

        try {
            while ($object = $statement->fetch()) {
                yield $object;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    /**
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;
}
