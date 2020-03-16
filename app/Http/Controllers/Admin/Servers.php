<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class Servers extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list = DB::table('servers')
            ->select(
                "id","name","type","host",
                "web_url as webURL",
                "status_code as statusCode"
              )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }

    public function store(Request $request)
    {
        $form_data = $request->all();
        $result = DB::table('servers')
          ->insert([
            "name" => $form_data['name'],
            "type" => $form_data['type'],
            "web_url" => $form_data['webURL'],
            "host" => $form_data['host'],
          ]);
        if( $result ){
            return response()->json([
              'code' => '100',
              'message' => '创建成功！',
            ]);
        } else {
            return response([
                'message' => '创建失败!'
            ], 500);
        }
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('servers')
          ->where('id', $id)
          ->update([
            "name" => $form_data['name'],
            "type" => $form_data['type'],
            "web_url" => $form_data['webURL'],
            "host" => $form_data['host'],
            "lastUpdate" => date("Y-m-d h:i:sa")
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
        $result = DB::table('servers')->where('id', $id)->delete();
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
