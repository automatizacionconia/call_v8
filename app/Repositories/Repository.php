<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Criteria\Filter;

abstract class Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function search(Filter $filters)
    {
        $query = $this->model->query();

        foreach ($filters->getFilters() as $filter) {

            $column = $filter['column'];
            $operator = $this->resolveOperator($filter['operator']);
            $value = $filter['value'];

            if ($operator === 'like') {
                $value = '%' . $value . '%';
            }

            $query->where($column, $operator, $value);
        }

        return $query->get();
    }

    private function resolveOperator($operator)
    {
        $operatorsMap = [
            'where' => '=',
            'whereEqual' => '=',
            'whereNotEqual' => '<>',
            'whereLike' => 'like',
            'whereNotLike' => 'not like',
            'whereGreaterThan' => '>',
            'whereGreaterThanOrEqual' => '>=',
            'whereLessThan' => '<',
            'whereLessThanOrEqual' => '<=',
            'whereIn' => 'whereIn',
            'whereNotIn' => 'whereNotIn',
            'whereBetween' => 'whereBetween',
            'whereNotBetween' => 'whereNotBetween',
        ];

        return $operatorsMap[$operator] ?? '=';
    }
}
