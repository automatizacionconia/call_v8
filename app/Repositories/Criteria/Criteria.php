<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

abstract class Criteria
{
    abstract public function apply(Builder $queryBuilder): Builder;
}
