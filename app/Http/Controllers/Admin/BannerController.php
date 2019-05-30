<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Input;
use Auth;

class BannerController extends Controller{

    function index(){
        $searchArr = Input::except('page');
        $tjArr = get_tj_info(-1);
        $data = Banner::when($searchArr,function ($query,$searchArr){
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
        })->orderBy('id','desc')->paginate(10);
        $data->each(function ($item){
            $item->type  =  get_tj_info($item->type);
            $item->dstatus  = ($item->dstatus == 1)?'显示':'隐藏';
        });
        return view('admin.banner.index',compact('data','tjArr','searchArr'));
    }

    /*
         * 新增
         * */
    public function create(Request $request){
        $tjArr = get_tj_info(-1);
        if($request->isMethod('post')){
            $data = $this->validate($request, [
                'title'=>'required|unique:banner',
                'pic'=>'required',
            ],[
                'title.required' => '请填写标题',
                'title.unique' => '该标题已存在',
                'pic.*' => '请上传广告图片',
            ]);
            Banner::create([
                'title' => $data['title'],
                'pic' => $data['pic'],
                'type' => $request->type,
                'dstatus' => ($request->dstatus == 'on')?'1':'2',
            ]);
            return redirect(url('admin/banner'))->with('flash_message','新增成功!');
        }
        return view('admin.banner.create',compact('tjArr'));
    }

    /*
 * 编辑
 * */
    public function update($id,Request $request){
        $data = Banner::find($id);
        $tjArr = get_tj_info(-1);
        if($request->isMethod('post')){
            $data = $this->validate($request, [
                'pic'=>'required',
                'title'=>'required',
            ],[
                'pic.*' => '请上传图片',
                'intro.*' => '请填写标题',
            ]);
            Banner::where('id',$id)->update([
                'pic' => $data['pic'],
                'title' => $data['title'],
                'type' => $request->type,
                'dstatus' => ($request->dstatus == 'on')?'1':'2'
            ]);
            return redirect(url('admin/banner'))->with('flash_message','修改成功!');
        }
        return view('admin.banner.update',compact('data','tjArr'));
    }

    /**
     * 删除指定记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BannerObj = Banner::findOrFail($id);
        $BannerObj->delete();
        return redirect()->route('banner.index')->with('flash_message','记录删除成功!');
    }
}