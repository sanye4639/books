<?php
namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Models\V2\Books;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


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
                $item->type  = get_bookType2($item->type);
            });

        /*
         * toArray 仅仅转换了第一层，通过循环转换子集完成整个array转换。
         * */
        $data['home_zone'] = object_array(Banner::where(['dstatus'=>1])
            ->groupBy('type')
            ->get(['title','pic','type'])->toArray());

        /*
         * 原生sql恰恰相反，第一层为对象，子集为数组，可转换第一层即可完成整个数组转换，不过不需要。
         * */
        $home_data = DB::select("SELECT a.id,a.name,a.pic,a.writer,a.intro,a.over,a.type,a.tj FROM book_list2 AS a,(SELECT GROUP_CONCAT(id order by sort desc) AS ids FROM book_list2 where dstatus = 1 and tj >0 GROUP BY tj) AS b WHERE FIND_IN_SET(a.id, b.ids) BETWEEN 1 AND 3 ORDER BY a.tj ASC, a.sort DESC");

        foreach($data['home_zone'] as $key => $val){
            foreach($home_data as $k=>$v){
                $v->over  = ($v->over == 1)?'连载':'完结';
                $v->type  = get_bookType2($v->type);
                if($val['type'] == $v->tj){
                    $data['home_zone'][$key]['datas'][] = $v;
                }
            }
        }
        return echojson('ok',1,$data);
    }
}