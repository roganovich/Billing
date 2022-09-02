<?php

namespace App\Filters;

class AccountsFilter extends AbstractFilter
{
    protected $filters = [
        'code' => LikeFilter::class,
        'user_id' => LikeFilter::class,
        'type_id' => LikeFilter::class,
        'title' => LikeFilter::class,
        'status' => LikeFilter::class,
        'balance' => LikeFilter::class,
        'description' => LikeFilter::class,
        'created_at' => LikeFilter::class,
        'updated_at' => LikeFilter::class,
    ];

    protected $sortables = [
        'code' => DefaultSort::class,
        'user_id' => DefaultSort::class,
        'type_id' => DefaultSort::class,
        'title' => DefaultSort::class,
        'status' => DefaultSort::class,
        'balance' => DefaultSort::class,
        'created_at' => DefaultSort::class,
        'updated_at' => DefaultSort::class,
    ];
}
