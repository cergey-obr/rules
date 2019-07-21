<?php

namespace App\Repository;

use App\Entity\Action;

class ActionRepository extends AbstractRepository
{
    protected $table = 'action';
    protected $model = Action::class;
}
