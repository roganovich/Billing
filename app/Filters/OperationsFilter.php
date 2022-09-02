<?php

namespace App\Filters;

class OperationsFilter extends AbstractFilter
{
    protected $filters = [
        'title' => LikeFilter::class,
        'description' => LikeFilter::class,
    ];

    protected $sortables = [
        'title' => DefaultSort::class,
        'updated_at' => DefaultSort::class,
    ];
}
