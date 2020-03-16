<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class Configurations extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function getConfigurations($algorithmId,$userId)
  {
      $privateList = DB::table('configurations')
          ->where("configurations.algorithmId", $algorithmId)
          ->where("configurations.userId",$userId)
          ->select(
              "configurations.id",
              "configurations.data",
              "configurations.algorithmId",
              "configurations.name",
              "configurations.lastUpdate"
            )
            ->get()
            ->toArray();

            return response()->json([
                'data' => [
                  'privateList'=>$privateList
              ],

            ]);
  }

  public function getWidgetList($configurationId)
  {
      $result = DB::table('configurations')
          ->join('algorithms', 'configurations.algorithmId', '=', 'algorithms.id')
          ->where("configurations.id", $configurationId)
          ->select(
              "configurations.id",
              "configurations.data",
              "configurations.algorithmId",
              "configurations.name",
              "configurations.lastUpdate",
              "algorithms.step_time as stepSize",
              "algorithms.packet_size as packageSize"
            )
            ->first();

            return response()->json([
                'data' => $result,
                'code' =>100
            ]);
  }

  public function deleteWidgetList(Request $request,$id){
    $result = DB::table('configurations')->where('id', $id)->delete();
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

  public function putWidgetList(Request $request,$configurationId)
  {
    $form_data = $request->all();
    $lastUpdate = date("Y-m-d h:i:sa");

    if($configurationId==0){
      $result = DB::table('configurations')
        ->insert([
          "data" => $form_data['data'],
          "name" => $form_data['name'],
          'algorithmId' => $form_data['algorithmId'],
          'userId' => $form_data['userId'],
          "lastUpdate" => $lastUpdate
        ]);

        if( $result ){
          $result = DB::table('configurations')
              ->where("configurations.lastUpdate", $lastUpdate)
              ->select(
                  "configurations.id",
                  "configurations.data",
                  "configurations.algorithmId",
                  "configurations.name",
                  "configurations.lastUpdate"
                )
                ->first();

                return response()->json([
                  'code' => '100',
                  'target' => $result,
                  'message' => '更新成功！',
                ]);


        } else {
            return response([
                'message' => '更新失败!'
            ], 500);
        }
    }


    $result = DB::table('configurations')
      ->where('id', $configurationId)
      ->update([
        "data" => $form_data['data'],
        "name" => $form_data['name'],
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

}
