<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Visitor;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;

class VisitorController extends Controller{
    public function index(){
        $searchArr = Input::except('page');
        $data = Visitor::with('book')->whereHas('book',function($query) use ($searchArr){
            $query->when($searchArr,function ($query)use($searchArr){
                    foreach($searchArr as $k=>$v){
                        if(count($v)>0){
                            if($k =='book_id'){
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
                    }elseif($k =='visitor_ip'){
                        $query->where($k,$v);
                    }
                }
            }
        })->orderBy('id','desc')->paginate(15);
        return view('admin.visitor.index',compact('data','searchArr'));
    }
    /**
     * 删除指定记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitorObj = Visitor::findOrFail($id);
        $visitorObj->delete();
        return redirect()->route('visitor.index')->with('flash_message','记录删除成功!');
    }
}