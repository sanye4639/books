<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;

class Search_LogController extends Controller{
    public function index(){
        $searchArr = Input::except('page');
        $data = DB::table('search_log')
            ->select(['keywords',DB::raw('count(id) as search_num')])
            ->when($searchArr,function ($query,$searchArr){
            foreach($searchArr as $k=>$v){
                if(count($v)>0){
                    if($k =='keywords'){
                        $query->where($k,'like','%'.$v.'%');
                    }
                }
            }
        })->groupBy('keywords')->orderBy('search_num','desc')->paginate(15);
        return view('admin.search_log.index',compact('data','searchArr'));
    }

}