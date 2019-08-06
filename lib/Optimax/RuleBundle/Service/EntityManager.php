<?php

namespace Optimax\RuleBundle\Service;

use Doctrine\DBAL\Connection;
use Optimax\RuleBundle\Repository\AbstractRepository;

class EntityManager
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param string $entityName
     *
     * @return AbstractRepository
     * @throws \InvalidArgumentException
     */
    public function getRepository(string $entityName): AbstractRepository
    {
        $className = 'Optimax\RuleBundle\Repository\\' . ucfirst($entityName) . 'Repository';
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Unknown repository for entity: {$entityName}");
        }

        return new $className($this);
    }
}
