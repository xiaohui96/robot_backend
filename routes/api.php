<?php

use Illuminate\Http\Request;

Route::post('/login','Auth\LoginController@login');
Route::get('/verifyLogin','Auth\LoginController@verifyLogin');
Route::get('/logout','Auth\LoginController@logout');

Route::post('/regist','Auth\RegisterController@regist');
Route::post('/registcaptcha','Auth\RegisterController@registCaptcha');

Route::post('/forgotpwd','Auth\ForgotPasswordController@forgotPassword');
Route::post('/resetpwd','Auth\ResetPasswordController@resetPassword');

Route::get('/labmenu','App\App@getLabMenu');
Route::get('/labmenuN','App\AppN@getLabMenu');
Route::get('/plantinfo/{path}','App\App@getPlantInfo');

Route::get('/getPlants/{serverId}','App\AppN@getPlants');

Route::get('/getConfigurations/{algorithmId}/{userId}','App\Configurations@getConfigurations');

Route::get('/widgetslist/{configurationId}','App\Configurations@getWidgetList');

Route::post('/widgetslist/{configurationId}','App\Configurations@putWidgetList');

Route::delete('/widgetslist/{configurationId}','App\Configurations@deleteWidgetList');

Route::put('/addNewMessage','App\Chatroom@addNewMessage');
Route::post('/getMessages','App\Chatroom@getMessages');

Route::get('/getAlarmInformation','App\Alarm@getAlarmInformation');
Route::get('/getPatrolParameters','App\Alarm@getPatrolParameters');
Route::get('/getTasks','App\Alarm@getTasks');
Route::put('/alarmInformation/{Id}','App\Alarm@update');
Route::put('/patrolInformation/{Id}','App\Alarm@patrolUpdate');
Route::put('/task/{Id}','App\Alarm@taskupdate');
Route::delete('/task/{Id}','App\Alarm@taskdestroy');
Route::delete('/alarmInformation/{Id}','App\Alarm@destroy');
Route::post('/alarmInformation','App\Alarm@store');
Route::get('/getMapInformation','App\Robot@getMapInformation');
Route::get('/getPatrolResult','App\Patrol@getPatrolResult');
Route::put('/patrol/{Id}','App\Patrol@update');
Route::delete('/patrol/{Id}','App\Patrol@destroy');
Route::get('/getMap','App\Map@getMap');
Route::put('/map/{Id}','App\Map@update');
Route::post('/map/{Id}','App\Map@store');
Route::delete('/map/{Id}','App\Map@destroy');
Route::get('/robotInfo','App\RobotInfo@getRobotInfo');
Route::put('/robotInfo/{Id}','App\RobotInfo@update');
Route::post('/robotInfo/{Id}','App\RobotInfo@store');
Route::delete('/robotInfo/{Id}','App\RobotInfo@destroy');
Route::get('/getAlarmSetting','App\AlarmSetting@getAlarmSetting');
Route::put('/alarmSetting/{Id}','App\AlarmSetting@update');
Route::post('/alarmSetting/{Id}','App\AlarmSetting@store');
Route::delete('/alarmSetting/{Id}','App\AlarmSetting@destroy');

Route::apiResources([
    'sysconfig' => 'Admin\SystemConfig',
    'cameras' => 'Admin\Cameras',
    'labs' => 'Admin\Labs',
    'users' => 'Admin\Users',
    'robotConfig' => 'App\Robot',
    'testrigs' => 'Admin\TestRigs',
     'servers' => 'Admin\Servers',



]);
