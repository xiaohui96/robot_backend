<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Mail\SendCaptcha;
use App\User;
use DB;
use Validator;
use Auth;
use Cache;
use Mail;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function regist(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'password' => 'required',
            'email' => 'required',
            'captcha' => 'required',
            'realname' => 'required',
        ]);
        $account = $request->input('account');
        $password = $request->input('password');
        $email = $request->input('email');
        $captcha = $request->input('captcha');
        $realname = $request->input('realname');

        $auth_code = 'robot2018';

        if ( User::where("account", $account)->first()) {
            return response()->json([
                'code' => 200,
                'messageCN' => '注册失败，用户名已被注册',
                'messageEN' => 'Registeration failed，the account has been used'
            ]);
        } else if ($captcha !== $auth_code & Cache::get($email) !== $captcha) {
            return response()->json([
                'code' => 201,
                'messageCN' => '注册失败，邮箱验证码错误',
                'messageEN' => 'Registeration failed，verification code error'
            ]);
        } else {
            $role = 6;
            if($captcha == $auth_code)
              $role = 3;
            $user = User::create([
                'account' => $account,
                'password' => Hash::make($password),
                'email' => $email,
                'realname' => $realname,
                'role' => $role
            ]);
            //注册后立即登陆
            if( $user ) {
                Auth::login($user);
                $user->last_land_time = Carbon::now();
                $user->save();
                return response()->json([
                    'code' => 100,
                    'messageCN' => '注册成功',
                    'messageEN' => 'Registeration successful',
                    'data' => Auth::user()->toArray(),
                ]);
            } else {
                return response([
                    'code' => 300,
                    'messageCN' => '注册失败，创建用户失败',
                    'messageEN' => 'Registeration failed，the account has not been created'
                ], 500);
            }
        }
    }

    public function registCaptcha(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $email = $request->input('email');
        $captcha = str_random(8);
        Mail::to($email)->send(new SendCaptcha($captcha));
        if( Mail::failures() ){
            return response([
                'code' => 300,
                'messageCN' => '邮件发送失败',
                'messageEN' => 'Email sent failed'
            ], 500);
        } else {
            Cache::put($email, $captcha, 30);
            return response()->json([
                'code' => '100',
                'messageCN' => '邮件发送成功',
                'messageEN' => 'Email sent successfully'
            ]);
        }
    }
}
