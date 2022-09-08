<?php

namespace App\Http\Controllers;

use App\Models\Wikipage;

class WikipagesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $item = Wikipage::where('slug',$slug)->first();

        return view('wikipages.show', [
            'item' => $item,
        ]);
    }

    /**
     * Количество записей в базе
     * @return int
     */
    public function getTotal()
    {
        return (int)Wikipage::count();
    }
}
