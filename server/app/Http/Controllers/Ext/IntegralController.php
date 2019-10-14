<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/27
 * Time: 10:34
 */

namespace App\Http\Controllers\Ext;


use App\Http\Controllers\Controller;
use App\Http\Success;
use App\Repository\Home\User\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repository\IntegralRepository;

class IntegralController extends Controller
{
    /**
     * 积分变动
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 11:08
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_integral(Request $request)
    {
        $this->validate($request,[
            'num' => 'required|numeric|max:10000|min:-10000',
            'id' => 'required|numeric',
            'event' => 'required|numeric|in:501,502'
        ]);

        $num = $request->input('num','');
        $id = $request->input('id','');
        $event = $request->input('event','');

        $data = IntegralRepository::add($event,$id,$num);

        if($data === false)
        {
            return Success::success_ext(Success::ext_sign_add_integral);
        }
        return Success::success_ext(Success::success,['data'=>$data]);
    }

    /**
     * 积分历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 10:46
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function integral_history(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
        ]);
        $id = $request->input('id','');
        $user = User::find($id);
        $data = [];
        if($id && $user)
        {
            $Repository = new UserRepository();
            $data = $Repository->integral($request,$user);
        }
        return Success::success_ext(Success::success,$data);
    }
}