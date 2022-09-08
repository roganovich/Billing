<?php

namespace App\Filters;

class OperationUserFilter
{
    public function filter($builder, $value, $filter = null)
    {
        if (!empty($value)) {
            return $builder->where('user_id', '=', $value);
        }
    }
}
