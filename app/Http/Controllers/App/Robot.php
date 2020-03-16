<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class Robot extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function getMapInformation()
    {
        $list = DB::table('test')
            ->select(
                //"map.id",
                //"map.title as title",
                //"map.key as key"
                "test.id",
                "test.treeData as treeData"
            )
            ->get()
            ->toArray();

        return response()->json([
            'data' => $list,
        ]);
    }
    public function show($key)
    {
        $params = DB::table('robot')
            ->where('key', $key)
            ->pluck('value')
            ->first();

        return response()->json([
            'data' => json_decode($params),
        ]);
    }

    public function update(Request $request, $key)
    {
        $this->validate($request, [
            'params' => 'required',
        ]);

        $params = $request->input('params');
        DB::table('robot')
            ->where('key', $key)
            ->update(['value' => json_encode($params)]);

        return response()->json([
            'code' => '100',
            'message' => '更新成功！',
        ]);
    }
}
