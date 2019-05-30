<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Visitor extends Model{
    //指定表名
    protected $table= 'visitor';
    //指定主键
    protected $primaryKey= 'id';
    //允许批量赋值字段
    protected $fillable = ['visitor_ip','book_id','visitor_num'];

    public $timestamps = true;

    public function insertLog($ip,$book_id){
        $today = date("Y-m-d",time());
        $tomorrow = date("Y-m-d",strtotime("+1 day"));
        $visitorData = Visitor::select(['id','updated_at'])
            ->where(['visitor_ip'=>$ip,'book_id'=>$book_id])
            ->where('updated_at','>',$today)
            ->where('updated_at','<',$tomorrow)
            ->first();
        if(count($visitorData)){
            $todayTime = strtotime(date('Y-m-d 23:59:59',strtotime($visitorData['updated_at'])));
            Visitor::where('id',$visitorData['id'])->increment('visitor_num');
            if(time() > $todayTime){
                DB::table('book_list')->where('id',$book_id)->increment('click_num');
            }
        }else{
            Visitor::create([
                'visitor_ip'=>$ip,
                'book_id'=>$book_id,
            ]);
            DB::table('book_list')->where('id',$book_id)->increment('click_num');
        }
    }
    public function book()
    {
        return $this->belongsTo('App\Models\Books','book_id');
    }

}
