<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Banner extends Model{
    //指定表名
    protected $table= 'banner';
    //指定主键
    protected $primaryKey= 'id';

    protected $fillable = ['title','pic','type','dstatus'];

    public $timestamps = true;

//    public function setUpdatedAtAttribute($value) {
//         Do nothing.
//    }

}