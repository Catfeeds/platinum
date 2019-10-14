<?php

namespace App\Http\Middleware\Home;

use App\Models\Home\Tarea;
use Closure;

class ProvinceCity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $province_id_s = null;
        $city_id_s = null;
        $area_id_s = null;
        // 省查询
        $province_id = $request->input('province','');
        if($province_id && strlen($province_id) != mb_strlen($province_id))
        {
            $province_id_s = Tarea::where('name',$province_id)->where('level',1)->value('id');
            $province_id_s = $province_id_s ? $province_id_s : null;
        }

        // 市查询
        $city_id = $request->input('city','');
        if($city_id && strlen($city_id) != mb_strlen($city_id))
        {
            $city_id_s = Tarea::where('name',$city_id)->where('level',2)->value('id');
            $city_id_s = $city_id_s ? $city_id_s : null;
        }

        // 区查询
        $area_id = $request->input('area','');
        if($area_id && strlen($area_id) != mb_strlen($area_id))
        {
            $area_id_s = Tarea::where('name',$area_id)->where('level',3)->value('id');
            $area_id_s = $area_id_s ? $area_id_s : null;
        }

        $request->request->set('province',$province_id_s);
        $request->request->set('city',$city_id_s);
        $request->request->set('area',$area_id_s);
        return $next($request);
    }
}
