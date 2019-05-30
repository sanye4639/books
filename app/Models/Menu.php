<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model{
    //指定表名
    protected $table= 'menu';
    //指定主键
    protected $primaryKey= 'id';

    protected $fillable = ['pid','menu_name','ac','icon_class','url_params','dstatus','permission_id'];

    public $timestamps = true;//false

    public function get_menu_list(){
        $menu_list = getTree(Menu::all());
        foreach($menu_list as $k=>$item){
            $item['dstatus'] = ($item['dstatus'] == 0)?'隐藏':'显示';
            $item['menu_name'] = str_repeat("　　",$item['level']+1).$item['menu_name'];
        }
        return $menu_list;
    }

    public function get_menu_children(){
        $menu_list = getTree2(Menu::where('dstatus','1')->get());
        return $menu_list;
    }
}