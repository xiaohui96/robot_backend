<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Mail\ForgotPWD;
use DB;
use Validator;
use Cache;
use Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $email = $request->input('email');
        $user = User::where('email', $email)
          ->first();
        if( $user ) {
          $forgotpwd_token = str_random(12);

          Mail::to($email)->send(new ForgotPWD($forgotpwd_token, $user->account));
          if( Mail::failures() ){
              return response([
                  'code' => 300,
                  'message' => '邮件发送失败'
              ], 500);
          } else {
              Cache::put($forgotpwd_token, $user, 30);
              return response()->json([
                  'code' => 100,
                  'message' => '邮件发送成功'
              ]);
          }
        } else {
            return response()->json([
                'code' => 200,
                'message' => '邮件地址不存在'
            ]);
        }
    }
}
