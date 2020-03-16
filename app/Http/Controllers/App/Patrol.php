<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class Patrol extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function getPatrolResult()
    {
        $list = DB::table('recognition_result')
            ->join('device_alarm','recognition_result.device_alarm_id','=','device_alarm.id')
            ->select(
                "recognition_result.id",
                "device_alarm.is_verified as verify",
                "recognition_result.recognition_type as recognitionType",
                "recognition_result.location",
                "recognition_result.recognition_value as recognitionValue",
                "recognition_result.alarm_type as alarmType",
                "recognition_result.recognition_time as recognitionTime",
                "recognition_result.collect_information as collectInformation"
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
        $result = DB::table('recognition_result')
            ->where('id', $id)
            ->update([
                "recognition_value" => $form_data['recognitionValue'],
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
    public function dstroy($id)
    {
        $result = DB::table('recognition_result')->where('id', $id)->delete();
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
