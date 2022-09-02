<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class AccountsUser
{
    /**
     * @param App\Models\User $user
     *
     * @return integer
     */
    public static function get_count($user)
    {
        $count = DB::table('accounts')
            ->where('user_id', $user->id)
            ->whereNull('deleted_at')
            ->count();

        return $count;
    }
}
