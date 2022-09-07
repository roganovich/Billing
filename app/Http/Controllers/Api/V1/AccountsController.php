<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\AccountResourceCollection;
use App\Http\Traits\UploadTrait;
use App\Models\Account;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
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
        $filter['user_id'] = Auth::user()->id;

        $query = Account::filter($filter)
            ->sort($request->sort)
            ->paginate(10);

        return new AccountResourceCollection($query);
    }

    /**
     * Получаем все типы
     *
     * @return \Illuminate\Http\Response
     */
    public function typeslist()
    {
        return Account::$types;
    }

    /**
     * Получаем все статусы
     *
     * @return \Illuminate\Http\Response
     */
    public function statuseslist()
    {
        return Account::$statuses;
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
            'type_id' => 'required',
            'title' => 'max:256|required',
            'description' => 'max:256|nullable',
        ]);
        $validate['user_id'] = Auth::user()->id;

        $count = Account::withTrashed()->count();

        $newId = $count + 1;
        $left = date('Ymd');
        // Генерируем номер счета
        $right = str_pad($newId, 8, '0', STR_PAD_LEFT);

        $code = $left . $right;
        $validate['code'] = $code;

        $model = Account::create($validate);

        return $model;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request, $id)
    {
        $validate = $request->validate([
            'type_id' => 'required',
            'amount' => 'required|numeric|between:0,999999.99',
        ]);

        $account = Account::findOrFail($id);

        $validate['account_id'] = $account->id;
        $validate['status_id'] = Operation::STATUS_NEW;
        $validate['balance'] = array_sum([$account->balance, $validate['amount']]);
        $validate['options'] = json_encode($validate);

        $model = Operation::create($validate);

        $account->balance = $model->balance;
        $account->save();

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
        return Account::findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function payment($id)
    {
        return Account::findOrFail($id);
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
            'title' => 'max:256|required',
            'description' => 'max:256|nullable',
        ]);

        $model = Account::findOrFail($id);
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
        $model = Account::findOrFail($id);
        $model->delete();
    }
}
