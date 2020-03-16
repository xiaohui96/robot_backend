<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class App extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getLabMenu(Request $request)
    {
        $lab_menu = [
          "nameCN" => "管理界面",
          "nameEN" => "Lab",
          "path" => "lab"
        ];
        $test_rigs_list = DB::table('module_content')
            ->select(
                "id",
                "module_id",
                "name_cn as nameCN",
                "name_en as nameEN",
                "path",
                "order"
              )
            ->orderBy('order')
            ->get()
            ->groupBy('module_id');

        $labs_list = DB::table('modules')
            ->select(
                "id",
                "path",
                "name_cn as nameCN",
                "name_en as nameEN",
                "order",
                "iconid as icon"
              )
            ->get()
            ->filter(function($value, $key) use($test_rigs_list) {
              return $test_rigs_list->has($value->id);
            });

        $labs_list->each(function($value, $key) use($test_rigs_list) {
          $value->children = $test_rigs_list[$value->id];
        });

        $lab_menu["children"] = $labs_list->toArray();

        return response()->json([
            'code' => 100,
            'data' => $lab_menu,
        ]);
    }


    public function GetPlantInfo($path){
        $result = DB::table('module_content')
            //->join('servers', 'test_rigs.server', '=', 'servers.id')
            ->where("path", $path)
            ->select(
                "module_content.id",
                "module_content.name_cn as nameCN",
                "module_content.name_en as nameEN",
                "module_content.module_id as labid",
                "module_content.path",
                "module_content.order"
              )
            ->get()
            ->toArray();
        if( $result ){
            return response()->json([
              'code' => '100',
              'data' => $result,
            ]);
        } else {
            return response([
                'message' => '未找到指定设备!'
            ], 404);
        }
    }

}
