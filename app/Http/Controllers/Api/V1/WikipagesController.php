<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WikiPage\WikiPageResourceCollection;
use App\Http\Traits\UploadTrait;
use App\Models\Wikipage;
use Illuminate\Http\Request;

class WikipagesController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Wikipage::filter($request->search)
            ->sort($request->sort)
            ->paginate(10);

        return new WikiPageResourceCollection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'menu_level' => 'numeric|nullable',
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'thumb' => '',
        ]);

        $model = Wikipage::create($validate);
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        return Wikipage::select('id', 'title', 'slug', 'menu_level', 'description')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'menu_level' => 'numeric|nullable',
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'thumb' => '',
        ]);

        $model = Wikipage::findOrFail($id);
        $model->update($validate);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Wikipage::findOrFail($id);
        $model->delete();
    }
}
