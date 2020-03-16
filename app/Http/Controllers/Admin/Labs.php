<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class Labs extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $labs = DB::table('labs')
            ->select(
                "id",
                "name_cn as nameCN",
                "name_en as nameEN",
                "iconid",
                "path",
                "order"
              )
            ->get()
            ->keyBy("id")
            ->all();

        $test_rigs = DB::table('test_rigs')
            ->select(
                "id",
                "name_cn as nameCN",
                "name_en as nameEN",
                "lab_id as labid",
                "model",
                "ip",
                "path",
                "status_code as statusCode",
                "manager",
                "order",
                "downloadPort",
                "monitorPort",
                "experimentTime",
                "defaultAlgorithm",
                "stepSize",
                "monitorPacketSize",
                "currentUser"
              )
            ->get();

        $test_rigs->each(function ($item, $key) use($labs){
          $lab_item = $labs[$item->labid];
          $lab_item->testRigs[] = $item;
        });

        return response()->json([
            'data' => collect($labs)->values()->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $form_data = $request->all();
        $result = DB::table('labs')
          ->insert([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "iconid" => $form_data['iconid'],
            "path" => $form_data['path'],
            "order" => $form_data['order']
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
        $result = DB::table('labs')
          ->where('id', $id)
          ->update([
            "name_cn" => $form_data['nameCN'],
            "name_en" => $form_data['nameEN'],
            "iconid" => $form_data['iconid'],
            "path" => $form_data['path'],
            "order" => $form_data['order'],
            "lastUpdate" => date("Y-m-d h:i:sa")
          ]);
        if( $result ){
            return response()->json([
              'code' => '100',
              'message' => '更新成功！',
            ]);
        } else {
            return response([
                'message' => '更新失败!！'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            DB::table('labs')->where('id', $id)->delete();
            DB::table('test_rigs')->where('lab_id', $id)->delete();
            DB::commit();

            return response()->json([
              'code' => '100',
              'message' => '删除成功！',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'message' => '删除失败!'
            ], 500);
        }
    }
}
