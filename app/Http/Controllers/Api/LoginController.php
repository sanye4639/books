<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use App\Models\User;

class LoginController extends Controller{

    /*
    * 登陆
    */
    public function doLogin(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required'       => '账号不可为空',
                'password.required'       => '密码不可为空',
            ]
        );
        if ($validator->fails()) {
            return echojson($validator->errors()->first(),0);
        }
        if(Auth::attempt(['name' => $request->get('username'), 'password' => $request->get('password')])){
            return echojson('登陆成功',1,Auth::user());
        }else{
            return echojson('账号或者密码错误',0);
        }
    }

    /*
     * 注册
     * */
    public function doReg(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:users',
                'password' => 'required|max:18|min:6',
            ],
            [
                'username.required'       => '账号不可为空',
                'username.unique'         => '账号已存在',
                'username.max'            => '名称太长啦~',
                'username.min'            => '名称太短啦~',
                'password.required'       => '密码不可为空',
                'password.min'            => '密码太短啦~',
                'password.max'            => '密码太长啦~',
            ]
        );
        if ($validator->fails()) {
            return echojson($validator->errors()->first(),0);
        }
        $user = User::create([
            'name' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
        ]);
        if($user){
            return echojson('注册成功',1,$user);
        }else{
            return echojson('注册失败',0);
        }
    }
}