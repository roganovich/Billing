<?php

namespace App\Filters;

class WikiPagesFilter extends AbstractFilter
{
    protected $filters = [
        'title' => LikeFilter::class,
        'slug' => LikeFilter::class,
        'description' => LikeFilter::class,
        'parent_id' => EqualFilter::class,
    ];

    protected $sortables = [
        'title' => DefaultSort::class,
        'slug' => DefaultSort::class,
        'parent_id' => ParentSort::class,
        'updated_at' => DefaultSort::class,
    ];
}
