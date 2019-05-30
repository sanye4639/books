<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;

class FeedbackController extends Controller{
    public function index(){
        $searchArr = Input::except('page');
        $data = DB::table('feedback')
            ->when($searchArr,function ($query,$searchArr){
                foreach($searchArr as $k=>$v){
                    if(count($v)>0){
                        if($k =='startDate'){
                            $query->where("created_at",'>=',$v.' 00:00:00');
                        }elseif($k =='endDate'){
                            $query->where("created_at",'<=',$v.' 23:59:59');
                        }else{
                            $query->where($k,$v);
                        }
                    }
                }
            })->orderBy('id','desc')->paginate(15);
        $data->each(function ($item){
           $item->pic = explode('#',$item->pic);
           $item->dstatusCn = ($item->dstatus == '0')?'未读':'已读';
        });
        return view('admin.feedback.index',compact('data','searchArr'));
    }

    /*
     * 已读反馈
     * */
    public function is_read($id,Request $request){
        if($request->ajax()){
            if(!$id){
                return response()->json(['msg'=>'缺少ID参数','status'=>0]);
            }
            DB::table('feedback')->where('id',$id)->update(['dstatus'=>1]);
            return response()->json(['msg'=>'success','status'=>1]);
        }
    }
    /**
     * 删除指定记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('feedback')->where('id',$id)->delete();
        return redirect()->route('feedback.index')->with('flash_message','记录删除成功!');
    }

}