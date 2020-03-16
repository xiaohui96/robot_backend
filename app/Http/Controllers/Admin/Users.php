<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class Users extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list = DB::table('users')
            ->select(
                "id", "account", "password", "email", "role",
                "tel","institution",
                "realname as realName",
                "last_land_time as lastLand",
                "created_at as regDate"
              )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('users')
          ->where('id', $id)
          ->update([
            "role" => $form_data['role'],
            "realname" => $form_data['realName'],
            "last_land_time" => $form_data['lastLand'],
            "created_at" => $form_data['regDate'],
            "institution" => $form_data['institution'],
            "tel" => $form_data['tel'],
            "id" => $form_data['id'],
            "account" => $form_data['account'],
            "email" => $form_data['email'],
          ]);
        if( $result ){
            return response()->json([
              'code' => '100',
              'message' => '更新成功！',
            ]);
        } else {
            return response([
                'message' => '更新失败!'
            ], 500);
        }
    }


    public function destroy($id)
    {
        $result = DB::table('users')->where('id', $id)->delete();
        if( $result ){
            return response()->json([
              'code' => '100',
              'message' => '删除成功！',
            ]);
        } else {
            return response([
                'message' => '删除失败!'
            ], 500);
        }
    }
}
