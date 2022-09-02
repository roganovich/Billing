<?php

namespace App\Http\Controllers;

use App\Models\Wikipage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $item = Wikipage::orderBy('created_at', 'desc')->first();

        return view('home', [
            'item' => $item,
        ]);
    }
}
