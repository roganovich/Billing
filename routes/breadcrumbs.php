<?php
/** Главная */
Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('default.home'), route('home'));
});

/** Статьи */
Breadcrumbs::for('wikipages.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('wikipages.index'), route('wikipages.index'));
});

Breadcrumbs::for('wikipages.show', function ($trail, $item) {
    $trail->parent('home');
    $trail->push(__('wikipages.index'), route('wikipages.index'));
    $trail->push($item->title, route('wikipages.show', ['id' => $item->id]));
});
