<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect, Input, Response;
use App\Services\OSS;


class FileController extends Controller{
    /**
     * 上传图片
     */
    public function uploadImg(Request $request){
        $file = $request->file('upfile');
        if (!$file) {
            exit("请上传图片");
        }
        if ($file->isValid()) {
            // 获取文件相关信息
            $allowed_extensions = ["png", "jpg", "gif","jpeg"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }
//            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $content = time().'_'.uniqid().'.'.$ext;
            $bucket = config('oss.BucketName');

            $dirtype=2;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
            switch($dirtype)
            {
                case 1: $attach_subdir = date('ymd'); break;
                case 2: $attach_subdir = date('ym'); break;
                case 3: $attach_subdir = 'ext_'.$ext; break;
                case 4: $attach_subdir = date('Ym'); break;
            }

            $object = "bookPic/" . $attach_subdir.'/'.$content;
            $result = OSS::publicUpload($bucket,$object,$realPath);
            if (!$result) {
                return echojson('上传图片失败',0);
            }
            $img_url = OSS::getPublicObjectURL($bucket,$object);
            if($img_url){
                return echojson('success',1,$img_url);
            }else{
               return echojson('图片路径获取失败',0);
            }
        }
    }
}