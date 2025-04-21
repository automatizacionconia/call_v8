<?php

namespace App\Repositories\Criteria;

class Filter
{
    private $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }
}
