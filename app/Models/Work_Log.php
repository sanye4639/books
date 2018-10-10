<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Work_Log extends Model{
    //指定表名
    protected $table= 'work_log';
    //指定主键
    protected $primaryKey= 'id';

    protected $fillable = ['admin_id','path','method','ip','input','sql'];

    public $timestamps = true;

    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}