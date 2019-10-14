<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/4
 * Time: 11:14
 */

namespace App\Repository;

use Illuminate\Support\Facades\Log;
use OSS\Core\OssException;
use OSS\OssClient;
class AliyunRepository
{
    /**
     * 图片上传到阿里云对象存储
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/26
     * Time: 16:30
     * @param $path
     * @return string
     */
    static function alibaba_oss($path)
    {
        $save_path = '';
        if(strstr($path,'loop-upload') === false)
        {
            try
            {
                $ossClient = new OssClient(env('ALKEYID'),env('ALSECRET'),env('ALENDPOINT'));
                // 存储空间名称
                $bucket= "loop-upload";
                $object = 'chando6th/'.date('Y').'/'.date('m').'/'.date('d').'/'.basename($path); // 文件名称
                $filePath = env('ROOT_PATH').'public/storage/'.$path; // 本地存路径
                // 上传阿里云
                $re_path = $ossClient->uploadFile($bucket,$object,$filePath);
                Log::info('图片上传到阿里云对象存储:'.json_encode($re_path));

                if(count($re_path) && isset($re_path['info']))
                {
                    $save_path = $re_path['info']['url'];
                }

                return $save_path;

            }
            catch (OssException $e)
            {
                return $e->getMessage();
            }
        }
        return $save_path;
    }
}