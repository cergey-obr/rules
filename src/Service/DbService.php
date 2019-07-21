<?php

namespace App\Service;

use App\Exceptions\DbErrorException;

class DbService
{
    /**
     * @var \mysqli
     */
    protected $connection;

    /**
     * @param string $dbUrl
     *
     * @throws \Exception
     */
    public function __construct(string $dbUrl)
    {
        $dbParams = parse_url($dbUrl);

        $connection = new \mysqli(
            $dbParams['host'] ?? '',
            $dbParams['user'] ?? '',
            $dbParams['pass'] ?? '',
            substr($dbParams['path'] ?? '', 1),
            $dbParams['port'] ?? 3306
        );

        if ($connection->connect_errno) {
            throw new \Exception("Failed connection to database");
        }

        $this->connection = $connection;
    }

    /**
     * @param string $sql
     *
     * @return \mysqli_result
     * @throws DbErrorException
     */
    public function execute(string $sql): \mysqli_result
    {
        if (!$result = $this->connection->query($sql)) {
            throw new DbErrorException('Database error for query: ' . $sql);
        }

        return $result;
    }
}
