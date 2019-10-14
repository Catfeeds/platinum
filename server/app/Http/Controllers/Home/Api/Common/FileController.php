<?php

namespace App\Http\Controllers\Home\Api\Common;

use App\Http\Success;
use App\Repository\Admin\CommonRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public $commonRepository;
    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }


    /**
     * 图片上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/30
     * Time: 10:57
     * @param Request $request
     */
    public function img_upload(Request $request)
    {
        $file = $request->file('file');
        // 文件上传失败
        if($file == null || !$file->isValid())
        {
            return Success::success_v2(Success::admin_upload_error);
        }
        // 验证文件大小
        if($file->getSize() > 5242880)
        {
            return Success::success_v2(Success::admin_img_up_size);
        }

        $data = $this->commonRepository->img_upload($request);

        return Success::success_v2(Success::success,$data);
    }
}
