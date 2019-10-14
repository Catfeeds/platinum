<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/18
 * Time: 9:45
 */

namespace App\Repository\Home\User;


use App\Models\Home\Member_addr;
use Illuminate\Http\Request;

class MemberAddrRepository
{
    /**
     * 地址list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:52
     * @param $user
     * @return mixed
     */
    public function list($user)
    {
        return Member_addr::where('m_id',$user->id)->whereDeleteWith()->get();
    }


    /**
     * 添加地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 9:49
     * @param Request $request
     * @param $user
     * @return bool
     */
    public function add(Request $request,$user)
    {
        $m_id = $user->id;
        $name = $request->input('name','');
        $mobile = $request->input('mobile','');
        $province_id = $request->input('province','');
        $city_id = $request->input('city','');
        $area_id = $request->input('area','');
        $addr = $request->input('addr','');
        $type = $request->input('type',0);      // 是否默认 0否 1是
        $delete = 0;

        $this->addr_type($type,$m_id);

        $member_addr = new Member_addr();
        $member_addr->m_id = $m_id;
        $member_addr->name = $name;
        $member_addr->mobile = $mobile;
        $member_addr->province_id = $province_id;
        $member_addr->city_id = $city_id;
        $member_addr->area_id = $area_id;
        $member_addr->addr = $addr;
        $member_addr->type = $type;
        $member_addr->delete = $delete;

        $data = $member_addr->save();

        return $data;
    }

    /**
     * 修改地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:27
     * @param Request $request
     * @param $user
     */
    public function up(Request $request,$user)
    {
        $m_id = $user->id;
        $id = $request->input('id','');
        $name = $request->input('name', '');
        $mobile = $request->input('mobile', '');
        $province_id = $request->input('province', '');
        $city_id = $request->input('city', '');
        $area_id = $request->input('area', '');
        $addr = $request->input('addr', '');
        $type = $request->input('type', 0);      // 是否默认 0否 1是
        $delete = 0;

        $this->addr_type($type, $m_id);

        $update = [];

        $member_addr = new Member_addr();
        $update['m_id'] = $m_id;
        $update['name'] = $name;
        $update['mobile'] = $mobile;
        $update['province_id'] = $province_id;
        $update['city_id'] = $city_id;
        $update['area_id'] = $area_id;
        $update['addr'] = $addr;
        $update['type'] = $type;

        $member_addr->where('id',$id)->update($update);
    }

    /**
     * 查询地址详情
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:28
     * @param $id
     * @param $user
     * @return mixed
     */
    public function get_addr($id,$user)
    {
        return Member_addr::where('m_id',$user->id)->where('id',$id)->whereDeleteWith()->first();
    }

    /**
     * 删除地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:39
     * @param $id
     * @param $user
     */
    public function addr_de($id,$user)
    {
        Member_addr::where('m_id',$user->id)->where('id',$id)->update(['delete' => 1]);
    }

    /**
     * 更改用户的所有地址为不是默认地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:19
     * @param $type
     * @param $m_id
     */
    public function addr_type($type,$m_id)
    {
        if($type == 1)
        {
            // 更改用户的所有地址为不是默认地址
            Member_addr::where('m_id',$m_id)->update(['type'=>0]);
        }
    }
}