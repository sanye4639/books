<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Work_Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;

class Work_LogController extends Controller{
    function index(){
        $searchArr = Input::except('page');
        $data = Work_Log::whereHas('admin',function($query) use ($searchArr){
            $query->select(['id','name'])
            ->when($searchArr,function ($query)use($searchArr){
                foreach($searchArr as $k=>$v){
                    if(count($v)>0){
                        if($k =='name'){
                            $query->where($k,$v);
                        }
                    }
                }
            });
        })->when($searchArr,function ($query,$searchArr){
                foreach($searchArr as $k=>$v){
                    if(count($v)>0){
                        if($k =='startDate'){
                            $query->where("created_at",'>=',$v.' 00:00:00');
                        }elseif($k =='endDate'){
                            $query->where("created_at",'<=',$v.' 23:59:59');
                        }
                    }
                }
        })->orderBy('id','desc')->paginate(15);
        return view('admin.work_log.index',compact('data','searchArr'));
    }

    /**
     * 删除指定记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $WorkLogObj = Work_Log::findOrFail($id);
        $WorkLogObj->delete();
        return redirect()->route('work_log.index')->with('flash_message','记录删除成功!');
    }
}