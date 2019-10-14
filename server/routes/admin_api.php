<?php

use Illuminate\Routing\Router;
use \Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('admin-api.route.prefix'),
    'namespace'     => 'Admin',
    'middleware'    => [
        'web',
        'admin.api.auth', // 登录验证
        'admin.api.operation.log', // 操作日志
        'admin.api.verify.xss' // xss过滤
    ],
],function (Router $router){

    $router->group([
        'middleware'    => [
            'admin.api.role.permission' // 权限验证
        ],
    ],function (Router $router){

        /**
         * 公共
         */
        $router->group([
            'prefix'        => 'common',
            'namespace'     => 'Common',
        ],function (Router $router){
            $router->post('img_upload','FileController@img_upload');                                        // 图片上传
        });

        /**
         * 基础管理
         */
        $router->group([
            'namespace'     => 'Base',
        ],function (Router $router){

            $router->post('store_list','StoreController@Store_list');                                       // 门店list
            $router->get('store_deta','StoreController@Store_deta');                                        // 门店详情
            $router->post('store_add','StoreController@Store_add');                                         // 门店添加
            $router->post('store_up','StoreController@Store_up');                                           // 门店修改
            $router->get('store_de','StoreController@Store_de');                                            // 门店删除

            $router->post('giftvoucher_list','GiftVoucherController@GiftVoucher_list');                     // 礼品券list
            $router->get('giftvoucher_deta','GiftVoucherController@GiftVoucher_deta');                      // 礼品券详情
            $router->post('giftvoucher_add','GiftVoucherController@GiftVoucher_add');                       // 礼品券添加
            $router->post('giftvoucher_up','GiftVoucherController@GiftVoucher_up');                         // 礼品券修改
            $router->get('giftvoucher_de','GiftVoucherController@GiftVoucher_de');                          // 礼品券删除

            $router->post('classs_list','ClasssController@Classs_list');                                    // 分类list
            $router->get('classs_deta','ClasssController@Classs_deta');                                     // 分类详情
            $router->post('classs_add','ClasssController@Classs_add');                                      // 分类添加
            $router->post('classs_up','ClasssController@Classs_up');                                        // 分类修改
            $router->get('classs_de','ClasssController@Classs_de');                                         // 分类删除
        });

    });
});