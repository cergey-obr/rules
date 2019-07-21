<?php

namespace App\Repository;

use stdClass;
use App\Service\DbService;
use App\Exceptions\DbErrorException;

abstract class AbstractRepository
{
    /**
     * @var DbService
     */
    protected $dbService;

    /**
     * @var string
     */
    protected $table;

    /**
     * @param DbService|null $dbService
     */
    public function __construct(?DbService $dbService = null)
    {
        if (!$this->dbService) {
            $this->dbService = $dbService;
        }
    }

    /**
     * @param int $id
     * @param string $className
     *
     * @return object|stdClass
     * @throws DbErrorException
     */
    public function findById(int $id, string $className)
    {
        $result = $this->dbService->execute("SELECT * FROM {$this->table} WHERE id = '{$id}'");
        return $result->fetch_object($className);
    }
}
