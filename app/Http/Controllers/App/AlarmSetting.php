<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class AlarmSetting extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function getAlarmSetting()
    {
        $list = DB::table('limit_value_info')
            ->select(
                "limit_value_info.id",
                "limit_value_info.limit_value_name as name",
                "limit_value_info.alarm_type as alarmType",
                "limit_value_info.up_limit_value as upValue",
                "limit_value_info.down_limit_value as downValue",
                "limit_value_info.alarm_rank as alarmRank"
            )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }
    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('limit_value_info')
            ->where('id', $id)
            ->update([
                "limit_value_name" => $form_data['name'],
                //"alarm_type" => $form_data['alarmType'],
                "up_limit_value" => $form_data['upValue'],
                "down_limit_value" => $form_data['downValue'],
                //"alarm_rank" => $form_data['alarmRank'],
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
    public function store(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('limit_value_info')
            ->insert([
                "id" => $id,
                "limit_value_name" => $form_data['name'],
                //"alarm_type" => $form_data['alarmType'],
                "up_limit_value" => $form_data['upValue'],
                "down_limit_value" => $form_data['downValue'],
                //"alarm_rank" => $form_data['alarmRank'],
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
    public function destroy($id)
    {
        $result = DB::table('limit_value_info')->where('id', $id)->delete();
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
