<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromptController extends Controller
{
    public function index()
    {
        //验证参数
        if(!empty(session('message')) && !empty(session('url')) && !empty(session('jumpTime'))){
            $data = [
                'message' => session('message'),
                'url' => session('url'),
                'jumpTime' => session('jumpTime'),
                'status' => session('status')
            ];
        } else {
            $data = [
                'message' => '请勿非法访问！',
                'url' => '/',
                'jumpTime' => 3,
                'status' => false
            ];
        }
        return view('admin.prompt',['data' => $data]);
    }
}