<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class Alarm extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function getAlarmInformation()
    {
        $list = DB::table('device_alarm')
            ->join('robot_info', 'device_alarm.id', '=', 'robot_info.id')
            ->select(
                "device_alarm.id",
                "robot_info.name as robotName",
                "device_alarm.robot_id as robotId",
                "device_alarm.station_id as stationId",
                "device_alarm.device_id as deviceId",
                "device_alarm.alarm_type as alarmType",
                "device_alarm.alarm_level as alarmLevel",
                "device_alarm.alarm_time as alarmTime",
                "device_alarm.alarm_description as alarmDescription",
                "device_alarm.is_verified as verified"

            )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }
    public function getPatrolParameters()
    {
        $list = DB::table('patrol_parameters')
            ->select(
                "patrol_parameters.id",
                "patrol_parameters.name_cn as patrolName",
                "patrol_parameters.property as property",
                "patrol_parameters.role as role"
            )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }
    public function getTasks()
    {
        $list = DB::table('task')
            ->select(
                "task.id",
                "task.station_id as stationId",
                "task.taskname as taskName"
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
        $result = DB::table('patrol_parameters')
            ->where('id', $id)
            ->update([
                "name_cn" => $form_data['patrolName'],
                "property" => $form_data['property'],
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
    public function patrolUpdate(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('device_alarm')
            ->where('id', $id)
            ->update([
                "is_verified" => $form_data['verified'],
                "verify_on" => date("Y-m-d h:i:sa")
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
    public function taskupdate(Request $request, $id)
    {
        $form_data = $request->all();
        $result = DB::table('task')
            ->where('id', $id)
            ->update([
                "taskName" => $form_data['taskName'],
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
        $result = DB::table('patrol_parameters')->where('id', $id)->delete();
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
    public function taskdestroy($id)
    {
        $result = DB::table('task')->where('id', $id)->delete();
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
    public function store(Request $request)
    {
        $form_data = $request->all();
        $result = DB::table('patrol_parameters')
            ->insert([
                "name" => $form_data['name'],
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
}
