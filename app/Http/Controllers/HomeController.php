<?php

namespace App\Http\Controllers;

use App\Models\Wikipage;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $item = Wikipage::where('menu_level', '=', 0)->first();

        return view('wikipages.show', [
            'item' => $item,
        ]);
    }
}
