<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/21
 * Time: 13:39
 */

namespace App\Repository;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GuzzleRepository
{
    /**
     * GET 请求
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 13:42
     * @param $url
     * @param array $options
     * @return string
     */
    static function get($url)
    {
        $client = new Client();
        try
        {
            $response = $client->get($url);
            return json_decode($response->getBody()->getContents(),true);
        }
        catch (\Exception $exception)
        {
            return false;
        }
    }

    /**
     * POST 请求
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 13:42
     * @param $url
     * @param array $options
     * @return string
     */
    static function post($url,$options = [])
    {
        Log::info('url:'.$url);
        Log::info($options);
        $client = new Client();
        try
        {
            $response = $client->request('POST',$url,$options);
            return json_decode($response->getBody()->getContents(),true);
        }
        catch (\Exception $exception)
        {
            Log::info($exception->getMessage());
            return false;
        }
    }
}