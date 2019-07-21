<?php

namespace App\Repository;

use App\Model\Action;

class ActionRepository extends AbstractRepository
{
    protected $table = 'action';
    protected $model = Action::class;
}
