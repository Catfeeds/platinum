<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/10
 * Time: 10:03
 */

namespace App\Repository;


class MapRepository
{
    /*
    * 中国正常GCJ02坐标---->百度地图BD09坐标
    * 腾讯地图用的也是GCJ02坐标
    * @param double $lat 纬度
    * @param double $lng 经度
    */

    static function Convert_GCJ02_To_BD09($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z =sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
        return array('lng'=>$lng,'lat'=>$lat);
    }

    static function rad($d)
    {
        return $d * M_PI / 180.0;
    }

    /**
     * 根据经纬度算距离，返回结果单位是公里，先纬度，后经度
     * @param string $lat1 纬度
     * @param string $lng1 经度
     * @param string $lat2 纬度
     * @param string $lng2 经度
     * @return float|int
     */
    static function GetDistance($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;

        $radLat1 = self::rad($lat1);
        $radLat2 = self::rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = self::rad($lng1) - self::rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;

        return $s;
    }

    /*
    * 百度地图BD09坐标---->中国正常GCJ02坐标
    * 腾讯地图用的也是GCJ02坐标
    * @param double $lat 纬度
    * @param double $lng 经度
    * @return array();
    */
    static function Convert_BD09_To_GCJ02($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array('lng'=>$lng,'lat'=>$lat);
    }

    /**
     * 两个经纬度距离计算
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/29
     * Time: 14:34
     * @param $data
     * @param $lat
     * @param $lng
     * @return mixed
     */
    static function data_distance($data,$lat,$lng)
    {
        // 两个经纬度距离计算
        if(count($data))
        {
            foreach ($data as $k=>$v)
            {
                if($v['lat'] != '' && $v['lng'] != '')
                {
                    $distance = self::GetDistance($lat,$lng,$v['lat'],$v['lng']);
                    if($distance > 1)
                    {
                        $distance = round($distance,1);
                        $distance_str = 0;
                    }
                    else
                    {
                        $distance_str = round($distance*1000,0);
                    }
                    $data[$k]['distance_str'] = $distance_str;
                    $data[$k]['distance'] = $distance;
                }
                else
                {
                    $data[$k]['distance'] = 0;
                }
            }
        }
        return $data;
    }
}