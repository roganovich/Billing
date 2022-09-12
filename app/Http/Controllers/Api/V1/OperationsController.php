<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Operation\OperationResourceCollection;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OperationsController extends Controller
{
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
        $filter = $request->search;
        // Админ видит все записи
        if (!Auth::user()->isAdmin) {
            $filter['user_id'] = Auth::user()->id;
        }

        $query = Operation::select('accounts.user_id as user_id', 'operations.*')
            ->join('accounts', function ($join) {
                $join->on('accounts.id', '=', 'operations.account_id');
            })
            ->filter($filter)
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

        $filter['id'] = $id;
        // Админ видит все записи
        if (!Auth::user()->isAdmin) {
            $filter['user_id'] = Auth::user()->id;
            $validator = Validator::make($filter, [
                'user_id' => 'required',
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                abort(403, 'Нет прав для просмотра этой страницы');
            }
        }

        $query = Operation::select('accounts.user_id as user_id', 'operations.*')
            ->join('accounts', function ($join) {
                $join->on('accounts.id', '=', 'operations.account_id');
            })
            ->filter($filter)->paginate(false);

        $collection = new OperationResourceCollection($query);

        return $collection->get(0);
    }

}
