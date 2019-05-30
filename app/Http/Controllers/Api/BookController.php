<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Visitor;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookController extends Controller{

    protected $page;
    protected $start;
    protected $pageSize = 10;
    protected $total_page;

    function __construct()
    {
        $this->page = Input::get('page')>1?Input::get('page'):1;
        $this->start = ($this->page-1)*$this->pageSize;
    }

    /*
    * 获取小说列表
    * @param string type 类型
    * @param string param 参数
    * return array $data 返回数据
    */
    public function index(){
        $type = Input::get('type');
        $param = Input::get('param');
        if(!$type or !$param)return echojson('error',0);
        $data = array();
        if($type == 'rank'){
            /*排行榜列表*/
            $data = Books::select(['book_list.*'])
                ->leftJoin('visitor as v',function ($join)use($param){
                    $join->on('v.book_id','=','book_list.id')
                        ->when($param,function ($query,$param){
                            switch ($param){
                                case 1: //日点击榜
                                    $query->where('v.updated_at','>',date('Y-m-d',strtotime('-1 day')));
                                    break;
                                case 2: //周点击榜
                                    $query->where('v.updated_at','>',date('Y-m-d',strtotime('-7 day')));
                                    break;
                                case 3: //月点击榜
                                    $query->where('v.updated_at','>',date('Y-m-d',strtotime('-30 day')));
                                    break;
                                case 4: //总点击榜
                                    break;
                            }
                        });
                })->groupBy('book_list.id')
                ->orderBy('v.visitor_num','desc')
                ->orderBy('book_list.sort','desc')
                ->offset($this->start)->limit($this->pageSize)
                ->get();
        }elseif(in_array($type,array('type','over','tj'))){
            /*分类 状态 推荐列表*/
            $data = Books::select([
                'id','name','pic','writer','intro','over','type'
            ])->where($type,$param)->where('dstatus','1')->orderBy('sort','desc')->offset($this->start)->limit($this->pageSize)->get();
        }
        if(count($data)>0){
            $data->each(function ($item){
                $item->over  = ($item->over == 1)?'连载':'完结';
                $item->type  = get_bookType($item->type);
            });
            return echojson('ok',1,$data);
        }else{
            return echojson('暂无数据',0);
        }
    }

    /*
    * 搜索小说
    * @param string type 搜索分类  作者/书名
    * @param string param 输入内容
    * return array $data 返回数据
    */
    public function search(){
        $type = Input::get('type');
        $param = Input::get('param');
        if(!$type or !$param)return echojson('暂无数据',0);
        /*模糊查询 ，按关键词匹配度排序*/
        $data = Books::select([
            'id','name','pic','writer','intro','over','type',DB::raw("(length(".$type.")-length('".$param."')) as rn")
        ])->when($param,function ($query)use($type,$param){
            if($type){
                $query->where($type,'like','%'.$param.'%');
            }
        })->where('dstatus','1')->orderBy('sort','desc')->orderBy('rn','asc')->get();
        if(count($data)>0){
            DB::table('search_log')->insert(['keywords'=>$param,'created_at'=>date('Y-m-d H:i:s',time())]);
            $data->each(function ($item){
                $item->over  = ($item->over == 1)?'连载':'完结';
                $item->type  = get_bookType($item->type);
            });
            return echojson('ok',1,$data);
        }else{
            return echojson('暂无数据',0);
        }
    }

    /*
    * 小说详情页面
    * @param int id 小说ID
    * @param int orderBy 章节排序规则  1正序  2倒序
    * return array $data 返回数据
    */
    public function detail(){
        $book_id = Input::get('id');
        $orderBy = Input::get('orderBy',1);

        $data = Books::select(['id','name','pic','writer','type','over','intro','updated_at'])->find($book_id);
        $data['typeCn'] = get_bookType($data->type);
        $data['overCn'] = ($data->over == 1)?'连载':'完结';

        /*最新章节列表*/
        $chapter_tableName = 'booksChapter.book_chapter_'.$book_id%100;
        $data['new_chapterList'] = DB::table($chapter_tableName)
            ->select(['id','book_id','title','oss_url'])
            ->whereBook_id($book_id)
            ->orderBy('sort','desc')->limit(5)->get();

        /*章节列表*/
        $data['chapterList'] = DB::table($chapter_tableName)
            ->select(['id','book_id','title','oss_url'])
            ->whereBook_id($book_id)
            ->when($orderBy,function ($query) use ($orderBy){
                if($orderBy == 1){
                    $query->orderBy('sort','asc');
                }else{
                    $query->orderBy('sort','desc');
                }
            })->offset($this->start)->limit($this->pageSize)->get();

        $first_chapter_id = DB::table($chapter_tableName)->select(['id'])->whereBook_id($book_id)->orderBy('sort','asc')->first();//第一章节ID
        $count = DB::table($chapter_tableName)->whereBook_id($book_id)->count();//总数

        $data['first_chapter_id'] = ($first_chapter_id->id)?$first_chapter_id->id:'';
        $data['orderBy'] = $orderBy;
        $data['total_page'] = ceil($count/$this->pageSize);//共多少页
        $data['lastPage'] = $this->page > 1?intval($this->page)-1:1;//上一页
        $data['thisPage'] = $this->page;
        $data['nextPage'] = $this->page < $data['total_page']?intval($this->page)+1:$data['total_page'];//下一页

        $ip = get_client_ip_from_ns();
        $visitorObj = new Visitor;
        $visitorObj->insertLog($ip,$book_id);
        return echojson('ok',1,$data);
    }
    /*
    * 小说章节内容
    * @param int id 小说ID
    * @param int chapter_id 章节ID
    * return array $data 返回数据
    */
    public function bookContent(){
        $id = Input::get('id');
        $chapter_id = Input::get('chapter_id');
        $data = Books::select(['id','name'])->find($id);
        $chapter_tableName = 'booksChapter.book_chapter_'.$id%100;

        $chapter_data = DB::table($chapter_tableName)->whereId($chapter_id)->first();
        if(!$chapter_data)return echojson('暂无数据',0);
        $chapter_data = get_object_vars($chapter_data);
        $book_url = config('oss.OSSDomain').$chapter_data['oss_url'];
        /*打开远程文件txt获取内容*/
        $handle = fopen($book_url, 'r');
        $content = '';
        while(!feof($handle)){
            $content .= fgets($handle).'<br>';
        }
        $data['content'] = $content;
        fclose($handle);
        /*去除章节内容里标题*/
        $data['title'] = $chapter_data['title'];
        $data['content'] = preg_replace('/###([^^]*?)+###/','',$data['content']);
        /*获取上一页下一页的章节ID*/
        $lastObj = DB::table($chapter_tableName)->select(['id'])->where('sort','<',$chapter_data['sort'])->whereBook_id($id)->orderBy('sort','desc')->first();
        $data['last_chapterId'] = ($lastObj)?get_object_vars($lastObj)['id']:0;
        $nextObj = DB::table($chapter_tableName)->select(['id'])->where('sort','>',$chapter_data['sort'])->whereBook_id($id)->orderBy('sort','asc')->first();
        $data['next_chapterId'] = ($nextObj)?get_object_vars($nextObj)['id']:0;

        $ip = get_client_ip_from_ns();
        $visitorObj = new Visitor;
        $visitorObj->insertLog($ip,$id);
        return echojson('ok',1,$data);
    }

}