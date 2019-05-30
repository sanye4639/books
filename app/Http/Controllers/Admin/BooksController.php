<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Services\OSS;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;

class BooksController extends Controller{
    public $tj_info;
    protected $booksChapter;

    public function __construct()
    {
        $this->tj_info = get_tj_info(-1);
        $this->booksChapter = 'booksChapter';
    }
    /*
     * 首页
     * */
    public function index(){
        /*获取列表显示样式*/
        $key = 'bookList_type_'.Auth::id();
        if(Input::get('showType')){
            $showType = Input::get('showType');
            Cache::put($key,$showType,24*60*30);
        }else{
            $showType = Cache::remember($key, 60*24*30, function() {
                return 'img';
            });
        }
        $orderBy = Input::get('orderBy',2);
        $recycle = Input::get('recycle');
        $searchArr = Input::except('orderBy','recycle','showType','page');
        /*获取推荐栏目分类*/
        $data['tjArr'] = $this->tj_info;
        /*获取小说分类*/
        $data['bookType'] = get_bookType(0);
        /*获取小说数据*/
//        DB::enableQueryLog();
        $books = Books::select([
            'id','name','type','pic','writer','intro','created_at','updated_at','deleted_at','click_num','review_num','over','num','dstatus','sort','tj','new_chapter'
        ])->when($recycle, function ($query) {
            /*获取回收车的数据*/
            $query->onlyTrashed();
        })->when($searchArr,function ($query,$searchArr){
            foreach($searchArr as $k=>$v){
                if(count($v)>0){
                    if($k =='name'){
                        $query->whereRaw("(name like '%$v%' or writer like '%$v%')");
                    }else{
                        $query->where($k,$v);
                    }
                }
            }
        })->when($orderBy,function ($query,$orderBy){
            switch ($orderBy){
                case 1:
                    $query->orderBy('sort','asc');
                    break;
                case 2:
                    $query->orderBy('sort','desc');
                    break;
                case 3:
                    $query->orderBy('updated_at','asc');
                    break;
                case 4:
                    $query->orderBy('updated_at','desc');
                    break;
            }

        })->orderBy('id','asc')->paginate(15);
        $books->each(function ($item){
            $item->tj  =  $this->tj_info[$item->tj];
            $item->over  = ($item->over == 1)?'连载':'完结';
            $item->dstatus  = ($item->dstatus == 1)?'显示':'隐藏';
            $item->type  = get_bookType($item->type);
        });
//        dd(DB::getQueryLog());
        $data['bookData'] = $books;
        /*获取回收车的总数*/
        $data['recycle_count'] = Books::onlyTrashed()->count();
        return view('admin.book.index',compact('data','showType','recycle','searchArr','orderBy'));
    }

    /*
     * 新增
     * */
    public function create(Request $request){
        $tjArr = $this->tj_info;
        $typeArr = get_bookType(0);
        if($request->isMethod('post')){
            $data = $this->validate($request, [
                'name'=>'required|unique:book_list',
                'url'=>'required|url',
                'pic'=>'required',
                'writer'=>'required',
                'intro'=>'required',
            ],[
                'name.required' => '请填写小说名',
                'name.unique' => '该小说已存在',
                'url.required' => '请填写抓取url',
                'url.url' => '请填写正确的url',
                'pic.*' => '请上传封面图片',
                'writer.*' => '请填写作者名称',
                'intro.*' => '请填写小说简介',
            ]);
            Books::create([
                'name' => $data['name'],
                'pic' => $data['pic'],
                'type' => $request->type,
                'writer' => $data['writer'],
                'intro' => $data['intro'],
                'over' => $request->over,
                'url' => $data['url'],
                'tj' => $request->tj,
                'dstatus' => ($request->dstatus == 'on')?'1':'2',
            ]);
            return redirect(url('admin/book').'?orderBy=2')->with('flash_message','新增成功!');
        }
        return view('admin.book.create',compact('tjArr','typeArr'));
    }

    /*
     * 编辑
     * */
    public function update($id,Request $request){
        $data = Books::find($id,['id','pic','intro','tj','dstatus']);
        $tjArr = $this->tj_info;
        if($request->isMethod('post')){
            $data = $this->validate($request, [
                'pic'=>'required',
                'intro'=>'required',
            ],[
                'pic.*' => '请上传图片',
                'intro.*' => '请填写小说简介',
            ]);
            Books::where('id',$id)->update([
                'pic' => $data['pic'],
                'intro' => $data['intro'],
                'tj' => $request->tj,
                'dstatus' => ($request->dstatus == 'on')?'1':'2'
            ]);
            return redirect(url('admin/book').'?orderBy=2')->with('flash_message','修改成功!');
        }
        return view('admin.book.update',compact('data','tjArr'));
    }

    /*
     * 详情
     * */
    public function detail($id){
        $key = 'bookList_type_'.Auth::id();
        $showType = Cache::get($key);
        $chapter_id = Input::get('chapter_id',-1);
        $orderBy = Input::get('orderBy');
        $searchArr = Input::except('page');
        $data = Books::select(['id','name'])->find($id);
        $chapter_tableName = $this->booksChapter.'.book_chapter_'.$id%100;
        if($chapter_id == -1){
            if($showType == 'img'){
                $chapterList = DB::table($chapter_tableName)
                    ->whereBook_id($id)
                    ->when($orderBy,function ($query){
                        $query->orderBy('sort','desc');
                    })->orderBy('sort','asc')->get()
                    ->map(function ($value) {
                        return (array)$value;
                    })->toArray();
            }else{
                $chapterList = DB::table($chapter_tableName)
                    ->whereBook_id($id)
                    ->when($searchArr,function ($query,$searchArr){
                        foreach($searchArr as $k=>$v){
                            if(count($v)>0){
                                if($k =='title'){
                                    $query->where("title","like","%$v%");
                                }else{
                                    $query->where($k,$v);
                                }
                            }
                        }
                    })->orderBy('sort','asc')->paginate(15);
                $chapterList->each(function ($item){
                    $item->oss_url = config('oss.OSSDomain').$item->oss_url;
                });
            }
        }else{
            $chapterObj = DB::table($chapter_tableName)->whereId($chapter_id)->first();
            if(!$chapterObj)abort(404);
            $chapterList = get_object_vars($chapterObj);
            $book_url = config('oss.OSSDomain').$chapterList['oss_url'];
            /*打开远程文件txt获取内容*/
            $handle = fopen($book_url, 'r') or abort(404);
            $content = '';
            while(!feof($handle)){
                $content .= fgets($handle).'<br>';
            }
            $chapterList['content'] = $content;
            fclose($handle);
            /*获取上一页下一页的章节ID*/
            $lastObj = DB::table($chapter_tableName)->select(['id'])->where('sort','<',$chapterList['sort'])->whereBook_id($id)->orderBy('sort','desc')->first();
            $chapterList['last_chapterId'] = ($lastObj)?get_object_vars($lastObj)['id']:0;
            $nextObj = DB::table($chapter_tableName)->select(['id'])->where('sort','>',$chapterList['sort'])->whereBook_id($id)->orderBy('sort','asc')->first();
            $chapterList['next_chapterId'] = ($nextObj)?get_object_vars($nextObj)['id']:0;
        }
        return view('admin.book.detail',compact('chapterList','data','chapter_id','showType','searchArr'));
    }

    /*
     * 修改排序
     * */
    public function sort($id,Request $request){
        if($request->ajax()){
            $sort = Input::get('sort',0);
            if($id == 0){
                return response()->json(['msg'=>'缺少ID参数','status'=>0]);
            }
            $books = Books::find($id);
            $books->sort = $sort;
            $books->save();
            return response()->json(['msg'=>'success','status'=>1]);
        }
    }

    /*
     * 删除指定小说/章节
     */
    public function del(){
        $ids = explode(',',Input::get('id'));
        $recycle = Input::get('recycle',false);
        if($recycle == 'onlyTrashed'){
            $bucket = config('oss.BucketName');
            foreach ($ids as $v){
                $chapter_tableName = $this->booksChapter.'.book_chapter_'.$v%100;
                /*获取被软删除的数据*/
                $data = Books::select(['type','name'])->onlyTrashed()->find($v);
                $object = 'books/'.$data['type'].'/'.$data['name'];
                /*获取OSS 指定bucket下所有文件名*/
                $BucketArr = OSS::getAllObjectKeyWithPrefix($bucket,$object);
                /*删除文件*/
                OSS::publicDeleteObject($bucket,$BucketArr);
                /*删除章节表数据*/
                DB::table($chapter_tableName)->whereBook_id($v)->delete();
            }
            /*删除小说*/
            Books::withTrashed()->whereIn('id',$ids)->forceDelete();
        }elseif($recycle == 'chapter'){
            $book_id = Input::get('book_id');

            if(!$book_id) return response()->json(['msg'=>'缺少小说ID','status'=>0]);

            $chapter_tableName = $this->booksChapter.'.book_chapter_'.$book_id%100;
            $chapter_data = DB::table($chapter_tableName)->select(['oss_url'])->whereIn('id',$ids)->get();
            foreach ($chapter_data as $v){
                /*获取OSS 指定bucket下的文件名*/
                $BucketArr[] = $v->oss_url;
            }
            /*删除文件*/
            $bucket = config('oss.BucketName');
            OSS::publicDeleteObject($bucket,$BucketArr);
            /*删除章节表数据*/
            DB::table($chapter_tableName)->whereIn('id',$ids)->delete();
            /*改变小说的最新章节*/
            $new_chapter = DB::table($chapter_tableName)->select(['title'])->orderBy('sort','desc')->first();
            Books::where('id',$book_id)->update(['new_chapter'=>$new_chapter->title]);
        }else{
            Books::whereIn('id',$ids)->delete();
        }
        return response()->json(['msg'=>'success','status'=>1]);
    }

    /*
     * 还原小说
     * */
    public function restore(){
        $ids = explode(',',Input::get('id'));
        Books::withTrashed()->whereIn('id',$ids)->restore();
        return response()->json(['msg'=>'success','status'=>1]);
    }

    /*
    * 更改章节内容小说
    * */
    public function update_chapter($id){
        $chapter_tableName = $this->booksChapter.'.book_chapter_'.$id%100;
        $chapter_id = Input::get('chapter_id',0);
        $content = Input::get('content','');
        if(empty($content))return response()->json(['msg'=>'章节内容不能为空','status'=> 0]);
        $data = DB::table($chapter_tableName)->select(['oss_url'])->whereId($chapter_id)->first();
        if(count($data)>0){
            $data = get_object_vars($data);
            $bucket = config('oss.BucketName');
            $result = OSS::publicUploadContent($bucket, $data['oss_url'], $content);
            if($result){
                return response()->json(['msg'=>'success','status'=> 1]);
            }else{
                return response()->json(['msg'=>'修改失败','status'=> 0]);
            }
        }else{
            return response()->json(['msg'=>'章节ID异常','status'=> 0]);
        }
    }

    /*
      * 更新小说
      * */
    public function execPython($id){
        $data = Books::select(['name'])->find($id);
        if($data->count()){
            $return_var = exec('cd /home/books_python && /usr/bin/sudo /bin/sh crontab_scrapy.sh '.$data['name']);
            return response()->json(['msg'=>$return_var,'status'=> 1]);
        }else{
            return response()->json(['msg'=>'小说ID异常','status'=> 0]);
        }
    }

    /*
      * 更新章节
      * */
    public function execPythonChapter($id){
        $chapter_id = Input::get('chapter_id',0);
        $chapter_tableName = $this->booksChapter.'.book_chapter_'.$id%100;
        $data = DB::table($chapter_tableName)->select(['url','oss_url'])->whereId($chapter_id)->first();
        if(count($data)>0){
            $data = get_object_vars($data);
            $bucket = config('oss.BucketName');
            OSS::publicDeleteObject($bucket,$data['oss_url']);
            $return_var = shell_exec('cd /home/books_python && /usr/bin/sudo /bin/sh update_chapter.sh '.$data['url'].' '.$data['oss_url']);
            return response()->json(['msg'=>$return_var,'status'=> 1]);
        }else{
            return response()->json(['msg'=>'章节ID异常','status'=> 0]);
        }
    }
}
