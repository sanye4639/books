<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Http\Controllers\Controller;

class IndexController extends Controller{

    /*
    * 首页接口
    * return array $data 返回数据
    */
    function index(Request $request){

        $data['recommend'] = Books::where(['tj'=>2,'dstatus'=>1])
            ->orderBy('sort','desc')
            ->take(6)
            ->get(['id','name','pic','writer','intro','over','type'])
            ->each(function ($item){
                $item->over  = ($item->over == 1)?'连载':'完结';
                $item->type  = get_bookType($item->type);
            });
        $data['home_zone'] = [
            [
                'title' => '只要有机会，一定可以改写命运',
                'pic' => 'http://s7.rr.itc.cn/org/wapChange/20167_5_10/b0l04b9539090666538.jpg',
                'datas' =>  Books::where(['dstatus'=>1,'type'=>1])
                    ->orderBy('id','asc')->take(3)->get(['id','name','pic','writer','intro','over','type'])
                    ->each(function ($item){
                        $item->over  = ($item->over == 1)?'连载':'完结';
                        $item->type  = get_bookType($item->type);
                    }),
            ],
            [
                'title' => '忆当时年华，谁点相思，谁种桃花',
                'pic' => 'http://s7.rr.itc.cn/org/wapChange/20166_22_14/b3ca925803863874352.png',
                'datas' =>  Books::where(['dstatus'=>1,'type'=>4])
                    ->orderBy('id','asc')->take(3)->get(['id','name','pic','writer','intro','over','type'])
                    ->each(function ($item){
                        $item->over  = ($item->over == 1)?'连载':'完结';
                        $item->type  = get_bookType($item->type);
                    }),
            ],
            [
                'title' => '剧透来了，热播剧《欢乐颂》小说结局抢先看！',
                'pic' => 'http://s7.rr.itc.cn/org/wapChange/20165_20_15/b7kwxi63267749796596.jpg',
                'datas' =>  Books::where(['dstatus'=>1,'type'=>3])
                    ->orderBy('id','asc')->take(3)->get(['id','name','pic','writer','intro','over','type'])
                    ->each(function ($item){
                        $item->over  = ($item->over == 1)?'连载':'完结';
                        $item->type  = get_bookType($item->type);
                    }),
            ],
            [
                'title' => '全民表白日，跟男主、女主学着点……',
                'pic' => 'http://s7.rr.itc.cn/org/wapChange/20165_18_18/b6l3gh7319575386352.png',
                'datas' =>  Books::where(['dstatus'=>1,'type'=>3])
                    ->orderBy('id','desc')->take(3)->get(['id','name','pic','writer','intro','over','type'])
                    ->each(function ($item){
                        $item->over  = ($item->over == 1)?'连载':'完结';
                        $item->type  = get_bookType($item->type);
                    }),
            ],
        ];
        return echojson('ok',1,$data);
    }
}