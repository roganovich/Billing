<?php

namespace App\Filters;

class OperationsFilter extends AbstractFilter
{
    protected $filters = [
        'id' => EqualFilter::class,
        'type_id' => EqualFilter::class,
        'account_id' => EqualFilter::class,
        'user_id' => OperationUserFilter::class,
        'status_id' => EqualFilter::class,
        'title' => LikeFilter::class,
        'description' => LikeFilter::class,
    ];

    protected $sortables = [
        'type_id' => DefaultSort::class,
        'account_id' => DefaultSort::class,
        'status_id' => DefaultSort::class,
        'title' => DefaultSort::class,
        'updated_at' => DefaultSort::class,
    ];
}
