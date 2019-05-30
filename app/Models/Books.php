<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model{
    use SoftDeletes;

    //指定表名
    protected $table= 'book_list';
    //指定主键
    protected $primaryKey= 'id';
    //允许批量赋值字段
    protected $fillable = ['name','pic','type','writer','intro','over','url','tj','dstatus'];

    public $timestamps = true;

    protected $dates = ['deleted_at'];
}
