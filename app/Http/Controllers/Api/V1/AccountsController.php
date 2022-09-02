<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\AccountResourceCollection;
use App\Http\Traits\UploadTrait;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Account::filter($request->search)
            ->sort($request->sort)
            ->paginate(10);

        return new AccountResourceCollection($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeslist()
    {
        return Account::$types;
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
            'user_id' => 'required',
            'title' => 'max:256|required',
            'description' => 'max:256|nullable',
        ]);
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        return Account::select('id', 'title', 'description')->findOrFail($id);
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

    public function addimage(Request $request)
    {
        // Form validation
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = md5(time());
            // Define folder path
            $folder = '/uploads/images/accounts/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);

            return json_encode(['url' => $filePath]);
        }

    }
}
