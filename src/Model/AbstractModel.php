<?php

namespace App\Model;

use App\Service\DbService;

abstract class AbstractModel
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var DbService
     */
    public $dbService;
}
