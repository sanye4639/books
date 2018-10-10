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
                'name' => 'required',
                'password' => 'required',
            ],
            [
                'name.required'       => '账号不可为空',
                'password.required'       => '密码不可为空',
            ]
        );
        if ($validator->fails()) {
            return echojson($validator->errors()->first(),0);
        }
        if(Auth::attempt(['name' => $request->get('name'), 'password' => $request->get('password')])){
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
                'name' => 'required|unique:users|max:10|min:2',
                'password' => 'required|max:12|min:6',
            ],
            [
                'name.required'       => '账号不可为空',
                'name.unique'         => '账号已存在',
                'name.max'            => '名称太长啦~',
                'name.min'            => '名称太短啦~',
                'password.required'       => '密码不可为空',
                'password.min'            => '密码太短啦~',
                'password.max'            => '密码太长啦~',
            ]
        );
        if ($validator->fails()) {
            return echojson($validator->errors()->first(),0);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
        ]);
        if($user){
            return echojson('注册成功',1,$user);
        }else{
            return echojson('注册失败',0);
        }
    }
}