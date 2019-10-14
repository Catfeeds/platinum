<?php
use \Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group([
    'namespace' => 'Scrm'
],function (Router $router){
    $router->get('get_token','ScrmController@get_token');                                                   // 获取token
    $router->get('wx_auth','ScrmController@wx_auth');                                                       // 微信授权跳转
    $router->get('get_accesstoken','ScrmController@get_accesstoken');                                       // 获取 accesstoken
    $router->get('get_ticket','ScrmController@get_ticket');                                                 // 获取 ticket
    $router->get('is_member','ScrmController@is_member');                                                   // 判断是否是会员
    $router->get('register','ScrmController@register');                                                     // 会员注册register
    $router->get('query_member','ScrmController@query_member');                                             // 查询会员信息
    $router->get('update_member','ScrmController@update_member');                                           // 更新会员信息
    $router->get('coupon_list','ScrmController@coupon_list');                                               // 优惠券list
    $router->get('coupon_write','ScrmController@coupon_write');                                             // 优惠券核销
    $router->get('loyalty','ScrmController@loyalty');                                                       // 积分变动
    $router->get('info','ScrmController@info');                                                             // 积分查询
    $router->get('list','ScrmController@list');                                                             // 积分历史
    $router->get('receipt_add','ScrmController@receipt_add');                                               // 小票上传
    $router->get('receipt','ScrmController@receipt');                                                       // 小票历史

    // 微信授权重定向
    $router->get('redirecturl',function (\Illuminate\Http\Request $request){
        echo '<pre>';
        print_r($request->all());
    });
});

/**
 * 测试
 */
Route::get('sign','TestController@sign');                                                                   // 开放接口签名生成
//Route::get('integral','TestController@integral');                                                                     // 积分添加参数
Route::get('code','TestController@code');                                                                             // 小程序二维码生成测试
//Route::get('cash_withdrawal','TestController@cash_withdrawal');                                                       // 微信提现测试

Route::get('gift_stock','TestController@gift_stock');                                                       // 礼品库存同步到redis
Route::get('scrm_regist','TestController@scrm_regist');                                                     // 新用户-scrm注册逻辑测试