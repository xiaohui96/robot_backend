<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class Cameras extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list = DB::table('cameras')
            ->select(
                "id",
                "name_cn as nameCN",
                "name_en as nameEN",
                "web_url as webURL",
                "width", "height",
                "test_rig_id as testRigid",
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
        $result = DB::table('cameras')
          ->insert([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "web_url" => $form_data['webURL'],
            "width" => $form_data['width'],
            "height" => $form_data['height'],
            "test_rig_id" => $form_data['testRigid'],
            "status_code" => $form_data['statusCode']
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
        $result = DB::table('cameras')
          ->where('id', $id)
          ->update([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "web_url" => $form_data['webURL'],
            "width" => $form_data['width'],
            "height" => $form_data['height'],
            "test_rig_id" => $form_data['testRigid'],
            "status_code" => $form_data['statusCode'],
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
        $result = DB::table('cameras')->where('id', $id)->delete();
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
