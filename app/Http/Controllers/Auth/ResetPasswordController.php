<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Mail\ForgotPWD;
use DB;
use Validator;
use Cache;
use Mail;

class ResetPasswordController extends Controller
{
  public function resetPassword(Request $request)
  {
      $this->validate($request, [
          'password' => 'required',
      ]);
      // $token = $request->input('token');
      $password = $request->input('password');
      $id = $request->input('id');
      // if( !$token ){
      //     return response()->json([
      //         'code' => '200',
      //         'message' => '链接无效，缺少token参数'
      //     ]);
      // }

      // $user = Cache::get($token);
      // if( !$user ) {
      //     return response()->json([
      //         'code' => '201',
      //         'message' => '链接已失效'
      //     ]);
      // }

      User::find($id)
          ->update(['password' => Hash::make($password)]);

      return response()->json([
          'code' => '100',
          'message' => '密码重置成功'
      ]);
  }
}
