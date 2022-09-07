<?php

namespace App\Http\Controllers;

use App\Http\Resources\WikiPage\WikipageResourceCollection;
use App\Http\Resources\WikiPage\WikiParentResourceCollection;
use App\Models\Wikipage;
use Illuminate\Http\Request;

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
