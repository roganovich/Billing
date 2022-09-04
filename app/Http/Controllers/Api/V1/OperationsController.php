<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Operation\OperationResourceCollection;
use App\Http\Traits\UploadTrait;
use App\Models\Operation;
use Illuminate\Http\Request;

class OperationsController extends Controller
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
        $query = Operation::filter($request->search)
            ->sort($request->sort)
            ->paginate(10);

        return new OperationResourceCollection($query);
    }

    /**
     * Получаем все статусы
     *
     * @return \Illuminate\Http\Response
     */
    public function statuseslist()
    {
        return Operation::$statuses;
    }

    /**
     * Получаем все типы
     *
     * @return \Illuminate\Http\Response
     */
    public function typeslist()
    {
        return Operation::$types;
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
            'title' => 'required|max:255',
            'description' => 'required',
            'parent_id' => 'numeric|nullable',
        ]);

        $model = Operation::create($validate);
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
        return Operation::findOrFail($id);
    }

}
