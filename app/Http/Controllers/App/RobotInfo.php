<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class RobotInfo extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function getRobotInfo()
    {
        $list = DB::table('robot_info')
            ->select(
                "robot_info.id",
                "robot_info.name"
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
        $result = DB::table('robot_info')
            ->where('id', $id)
            ->update([
                "name" => $form_data['name'],
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
        $result = DB::table('robot_info')
            ->insert([
                "id" => $id,
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
    public function destroy($id)
    {
        $result = DB::table('robot_info')->where('id', $id)->delete();
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
