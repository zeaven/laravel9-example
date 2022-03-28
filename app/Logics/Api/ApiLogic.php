<?php

namespace App\Logics\Api;

use Auth;

/**
 *
 * @authors generator
 * @date    2022-03-22 16:11:52
 */
class ApiLogic
{
    // TODO:
    public function user()
    {
        if (Auth::attempt(['username' => 'a', 'password' => '123456'])) {
            request()->session()->regenerate();
            return ['token' => Auth::user()->createToken('test')->plainTextToken];
        }
        throw_e(0xf00042);
    }
}
