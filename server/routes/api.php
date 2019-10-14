<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * 开放接口
 */
Route::group([
    'prefix'        => 'ext',
    'namespace'     => 'Ext',
    'middleware' => ['ext.sign']
],function (Router $route){

    $route->get('get_user','ExtController@get_user');                                                       // 获取用户信息
    $route->post('is_user','ExtController@is_user');                                                        // 验证是否是用户
    $route->post('register','ExtController@register')
        ->middleware(['province_city']);                                                                                // 用户注册
    $route->post('user_up','ExtController@user_up')
        ->middleware(['province_city']);                                                                                // 用户修改

    $route->post('add_integral','IntegralController@add_integral');                                         // 积分变动
    $route->post('integral_history','IntegralController@integral_history');                                 // 积分历史

    $route->post('receipt_list','ReceiptController@receipt_list');                                          // 小票历史
    $route->post('receipt_add','ReceiptController@receipt_add');                                            // 小票上传

});


/**
 * 小程序api
 */
Route::group([
    'prefix'        => 'home',
    'namespace'     => 'Home\Api',
    'middleware'    => ['admin.api.verify.xss'],
],function (Router $route) {


    $route->get('api_login', function (Request $request) {
        $mobile = $request->input('mobile','');
        return login_jwt($mobile);
    });                                                                                                                 // 接口登录测试

    $route->post('login', 'AuthController@login')
    ->middleware(['province_city']);                                                                                    // 小程序登陆
    $route->post('decryptData', 'AuthController@decryptData');                                              // 微信手机号消息解密

    /**
     * 登录认证
     */
    Route::group([
        'middleware' => 'jwt.auth'
    ],function (Router $route){
        /**
         * 公共
         */
        $route->group([
            'prefix'        => 'common',
            'namespace'     => 'Common',
        ],function (Router $router){

            $router->post('img_upload','FileController@img_upload');                                        // 图片上传
            $router->get('store','SelectController@store')
            ->middleware(['province_city']);                                                                            // 门店查询
            $router->get('brand','SelectController@brand')
            ->middleware(['province_city']);                                                                            // 品牌查询
            $router->get('city','SelectController@city');                                                   // 城市信息查询
        });

        /**
         * 我的
         */
        $route::group([
            'namespace'     => 'User',
        ],function (Router $route){

            $route->get('userinfo','UserController@userinfo');                                              // 用户详细信息
            $route->post('user_detail','UserController@user_detail')
            ->middleware(['province_city']);                                                                            // 用户详细信息修改
            $route->post('user_base','UserController@user_base');                                           // 修改基础信息
            $route->post('integral','UserController@integral');                                             // 积分历史
            $route->get('sign_in','UserController@sign_in');                                                // 用户签到
            $route->post('sign_list','UserController@sign_list');                                           // 用户签到list

            $route->get('member_addr_list','MemberAddrController@member_addr_list');                        // 地址list
            $route->post('member_addr_add','MemberAddrController@member_addr_add')
                ->middleware(['province_city']);                                                                        // 添加地址
            $route->post('member_addr_up','MemberAddrController@member_addr_up')
                ->middleware(['province_city']);                                                                        // 修改地址
            $route->get('member_addr_de','MemberAddrController@member_addr_de');                            // 删除地址
            $route->get('member_addr_deta','MemberAddrController@member_addr_deta');                        // 获取地址详情

            $route->get('user_register_voucher','UserController@user_register_voucher');                    // 用户注册电子券领取
        });

        /**
         * 收据
         */
        $route::group([
            'namespace'     => 'Receipt',
        ],function (Router $route){

            $route->post('receipt','ReceiptController@receipt');                                            // 小票上传
        });

        /**
         * 礼品
         */
        $route::group([
            'namespace'     => 'Gift',
        ],function (Router $route){

            $route->post('gift_order','GiftOrderController@gift_order');                                    // 礼品兑换
        });

    });
});