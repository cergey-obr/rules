<?php

namespace App\Repository;

use App\Entity\Combination;

class CombinationRepository extends AbstractRepository
{
    protected $table = 'combination';
    protected $model = Combination::class;
}
