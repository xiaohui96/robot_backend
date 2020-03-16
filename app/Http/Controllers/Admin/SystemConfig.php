<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class SystemConfig extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($key)
    {
        $params = DB::table('sys_config')
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
        DB::table('sys_config')
            ->where('key', $key)
            ->update(['value' => json_encode($params)]);

        return response()->json([
            'code' => '100',
            'message' => '更新成功！',
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
