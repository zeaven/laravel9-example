<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorizonController extends Controller
{
    public function login(Request $request)
    {
        [$username, $password] = $request->fields(
            [
                'u' => 'required',
                'pwd' => 'required'
            ]
        );

        if (!$jwt_token = auth()->attempt(compact('username', 'password'))) {
            throw_e('账号密码错误');
        }

        return redirect('/horizon');
    }
}
