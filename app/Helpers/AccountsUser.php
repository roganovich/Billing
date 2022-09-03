<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AccountsUser
{
    /**
     * Возвращаем данные для работы авторизации по API
     * @param string $section_name
     * @return mixed
     */
    public static function getVueAuth(string $section_name)
    {
        $user_auth_data = [
            'isLoggedin' => false,
            'user' => Null,
            'accessToken' => Null,
        ];

        if (Auth::check()) {
            $user = Auth::user();

            $user_auth_data = [
                'isLoggedin' => true,
                'user' => $user,
                'accessToken' => $user->getAccessToken($section_name),
            ];
        }

        return base64_encode(json_encode($user_auth_data));
    }
}
