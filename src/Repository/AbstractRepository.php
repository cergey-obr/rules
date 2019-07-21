<?php

namespace App\Repository;

use stdClass;
use App\Service\DbService;
use App\Exceptions\DbErrorException;

abstract class AbstractRepository
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var DbService
     */
    protected $dbService;

    /**
     * @param DbService $dbService
     */
    public function __construct(DbService $dbService)
    {
        $this->dbService = $dbService;
    }

    /**
     * @param int $value
     * @param string $field
     *
     * @return object|stdClass
     * @throws DbErrorException
     */
    public function find(int $value, string $field = 'id')
    {
        $result = $this->dbService->execute("SELECT * FROM {$this->table} WHERE {$field} = '{$value}'");
        return $result->fetch_object($this->model);
    }
}
