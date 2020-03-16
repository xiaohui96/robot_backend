<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Validator;

class Chatroom extends Controller{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function addNewMessage(Request $request){
    $form_data = $request->all();

    $result = DB::table('chatroom')
      ->insert([
        "user" => $form_data['userId'],
        "plant" => $form_data['plantId'],
        "text" => $form_data['msg'],
        "time" => time()
      ]);
    if( $result ){


      $updateResult = DB::table('test_rigs')
        ->where('id', $form_data['plantId'])
        ->update([

          "lastMessage" => time()
        ]);


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

  public function getMessages(Request $request){
    $form_data = $request->all();


    $result = DB::table('chatroom')
        ->join('users', 'chatroom.user', '=', 'users.id')
        ->where("chatroom.plant", $form_data['plantId'])
        ->where("chatroom.time",">", $form_data['timeStart'])
        ->select(
            "chatroom.text",
            "users.account",
            "chatroom.time",
            "chatroom.user"
          )
          ->get()
          ->toArray();

          return response()->json([
              'data' => $result,
              'code' =>100
          ]);
  }
}
