<?php

namespace App\Helpers;

use App\Models\Wikipage;
class Menu
{
    /**
     * Возвращаем данные для верхнего меню
     * @return mixed
     */
    public static function getList()
    {
        $items = Wikipage::select('title', 'slug')
            ->where('menu_level', '>', 0)
            ->orderBy('menu_level', 'ASC')->get();

        return $items;
    }
}
