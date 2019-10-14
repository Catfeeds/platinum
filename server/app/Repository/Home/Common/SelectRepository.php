<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/9
 * Time: 16:50
 */

namespace App\Repository\Home\Common;


use App\Models\Home\Brand;
use App\Models\Home\Store;
use App\Models\Home\Tarea;
use App\Repository\MapRepository;
use Illuminate\Http\Request;

class SelectRepository
{
    /**
     * 门店查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 16:55
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $province = $request->input('province','');
        $city = $request->input('city','');
        $area = $request->input('area','');
        $lng = $request->input('lng','');
        $lat = $request->input('lat','');

        $query = Store::query();

        if($province) $query->where('province',$province);
        if($city) $query->where('city',$city);
        if($area) $query->where('area',$area);

        $data = $query->where('delete',2)->get()->toArray();

        // 数据初始化
        $data = $this->data_re_init($data);

        if($lat && $lng && count($data))
        {
            $data = $this->data_map_sort($data,$lat,$lng);
        }

        return $data;
    }

    /**
     * 返回数据初始化
     * 门店坐标转换-百度转腾讯
     * 字段初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 10:37
     * @param $data
     * @return mixed
     */
    private function data_re_init($data)
    {
        if(count($data))
        {
            foreach ($data as $k=>$v)
            {
                if($v['lat'] && $v['lng'])
                {
                    $lat_lng = MapRepository::Convert_BD09_To_GCJ02($v['lat'],$v['lng']);
                    $data[$k]['lat'] = $lat_lng['lat'];
                    $data[$k]['lng'] = $lat_lng['lng'];
                }

                $data[$k]['distance_str'] = 0;
                $data[$k]['distance'] = 0;
            }
        }
        return $data;
    }

    /**
     * 数据经纬度排序
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 10:09
     * @param $data
     * @param $lat
     * @param $lng
     * @return mixed
     */
    private function data_map_sort($data,$lat,$lng)
    {
        // 计算经纬度
        $data = MapRepository::data_distance($data,$lat,$lng);

        // 排序
        $data = data_order($data,'distance');

        return $data;
    }

    /**
     * 品牌查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 16:55
     * @param Request $request
     * @return mixed
     */
    public function brand(Request $request)
    {
        $province = $request->input('province','');
        $city = $request->input('city','');
        $area = $request->input('area','');

        $query = Brand::query();

        if($province) $query->where('province',$province);
        if($city) $query->where('city',$city);
        if($area) $query->where('area',$area);

        $data = $query->select('id','name')->get();

        return $data;
    }

    /**
     * 城市信息查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 10:49
     * @return mixed
     */
    public function city()
    {
        $path = $this->get_city_put_file_path();
        if(!is_file($path))
        {
            $this->city_put_file();
        }

        return json_decode(file_get_contents($path),true);
    }

    /**
     * 城市信息写入到文件
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 10:44
     */
    public function city_put_file()
    {
        $model = new Tarea();
        $re_data = [];
        $re_data['province_list'] = $model->where('level',1)->get()->pluck('name','code');
        $re_data['city_list'] = $model->where('level',2)->get()->pluck('name','code');
        $re_data['county_list'] = $model->where('level',3)->get()->pluck('name','code');

        file_put_contents($this->get_city_put_file_path(),json_encode($re_data));
    }

    /**
     * 城市文件路径
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 10:47
     * @return string
     */
    private function get_city_put_file_path()
    {
        return env('ROOT_PATH').'public/js/city.js';
    }
}