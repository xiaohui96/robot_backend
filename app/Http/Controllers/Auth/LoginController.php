<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendCaptcha;
use DB;
use Validator;
use Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'password' => 'required',
        ]);
        $account = $request->input('account');
        $password = $request->input('password');

        if (Auth::attempt(['account' => $account, 'password' => $password])) {
            $user = Auth::user();
            $user->last_land_time = Carbon::now();
            $user->save();
            // 认证通过...
            return response()->json([
                'code' => 100,
                'message' => '登陆成功！',
                'data' => Auth::user()->toArray(),
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => '账号密码错误！'
            ]);
        }
    }

    public function verifyLogin(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'data' => Auth::user()->toArray(),
            ]);
        } else {
            return response([
                'message' => '用户未登陆！'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'code' => 100,
            'message' => '已注销'
        ]);
    }
}
