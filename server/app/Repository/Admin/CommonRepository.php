<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/30
 * Time: 10:50
 */

namespace App\Repository\Admin;


use App\Repository\AliyunRepository;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CommonRepository
{

    /**
     * 图片上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/30
     * Time: 10:55
     * @param Request $request
     * @return false|string
     */
    public function img_upload(Request $request)
    {
        $path = $request->file('file')->store(config('admin-api.upload.directory.image'));
        if($path)
        {
            // 上传到阿里云oss
            $path = AliyunRepository::alibaba_oss(str_replace('public/','',$path));
            $path = str_replace('public/',img_path_get(),$path);
        }
        return ['path'=>$path];
    }

    /**
     * 文件上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/16
     * Time: 16:26
     * @param Request $request
     * @param int $is 1上传阿里云 2不上传阿里云
     * @return array
     */
    public function file_upload(Request $request,$is = 1)
    {
        $path = $request->file('file')->store(config('admin-api.upload.directory.file'));
        if($path)
        {
            if($is == 1)
            {
                // 上传到阿里云oss
                $path = AliyunRepository::alibaba_oss(str_replace('public/','',$path));
            }
            $path = str_replace('public/',img_path_get(),$path);
        }
        return ['path'=>$path];
    }

    /**
     * IP获取
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/1
     * Time: 11:34
     * @return string
     */
    public function ip() {
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    }
}