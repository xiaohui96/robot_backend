<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class TestRigs extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list = DB::table('test_rigs')
            ->select(
                "id",
                "name_cn as nameCN",
                "name_en as nameEN",
                "lab_id as labid",
                "ip",
                "path",
                "model",
                "status_code as statusCode",
                "manager",
                "order",
                "downloadPort",
                "monitorPort",
                "experimentTime",
                "defaultAlgorithm",
                "stepSize",
                "monitorPacketSize",
                "currentUser",
                "type" //摄像头只适用于实体设备类型 2019.12.04 ysw
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
        $result = DB::table('test_rigs')
          ->insert([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "lab_id" => $form_data['labid'],
            "path" => $form_data['path'],
            "model" => $form_data['model'],
            "ip" => $form_data['ip'],
            "status_code" => $form_data['statusCode'],
            "manager" => $form_data['manager'],
            "order" => $form_data['order'],
            "downloadPort" => $form_data['downloadPort'],
            "monitorPort" => $form_data['monitorPort'],
            "experimentTime" => $form_data['experimentTime'],
            "defaultAlgorithm" => $form_data['defaultAlgorithm'],
            "stepSize" => $form_data['stepSize'],
            "monitorPacketSize" => $form_data['monitorPacketSize'],
            "currentUser" => $form_data['currentUser'],
            "currentUsers" => '[0]', //$form_data['currentUsers'], 前端未做对应修改
            "sessionTimes" => '[0]',  //$form_data['sessionTimes']
            "type" => $form_data['type']
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
    }

    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('test_rigs')
          ->where('id', $id)
          ->update([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "lab_id" => $form_data['labid'],
            "path" => $form_data['path'],
            "model" => $form_data['model'],
            "ip" => $form_data['ip'],
            "status_code" => $form_data['statusCode'],
            "manager" => $form_data['manager'],
            "order" => $form_data['order'],
            "downloadPort" => $form_data['downloadPort'],
            "monitorPort" => $form_data['monitorPort'],
            "experimentTime" => $form_data['experimentTime'],
            "defaultAlgorithm" => $form_data['defaultAlgorithm'],
            "stepSize" => $form_data['stepSize'],
            "monitorPacketSize" => $form_data['monitorPacketSize'],
            "currentUser" => $form_data['currentUser'],
            "type" => $form_data['type'],
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
        $result = DB::table('test_rigs')->where('id', $id)->delete();
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
