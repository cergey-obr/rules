<?php

namespace Optimax\RuleBundle\Repository;

use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOStatement;
use Optimax\RuleBundle\Entity\Rule;

class RuleRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'rule';
    }

    protected function getModelClass(): string
    {
        return Rule::class;
    }

    /**
     * @param string $target
     *
     * @return \Generator
     * @throws DBALException
     */
    public function getAvailableRules(string $target): \Generator
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE target = ? 
            AND (dateFrom is null or dateFrom <= ?) 
            AND (dateTo is null or dateTo >= ?) 
            AND active = 1 
        ORDER BY priority DESC";

        /** @var PDOStatement $statement */
        $statement = $this->connection->executeQuery($sql, [$target, $now = date('Y-m-d'), $now]);
        $statement->setFetchMode(FetchMode::CUSTOM_OBJECT, $this->getModelClass(), [$this->entityManager]);

        try {
            while ($rule = $statement->fetch()) {
                yield $rule;
            }
        } finally {
            $statement->closeCursor();
        }
    }
}
