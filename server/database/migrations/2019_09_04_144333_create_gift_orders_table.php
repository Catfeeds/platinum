<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->comment('订单号');
            $table->integer('g_id')->comment('礼品id');
            $table->integer('num')->comment('礼品数量');
            $table->integer('integral')->comment('订单总积分');
            $table->integer('u_id')->comment('用户id');
            $table->integer('u_d_id')->comment('用户收货地址id');
            $table->integer('state')->comment('状态 1待发货 2已发货 3已收货 4待领取 5已领取');
            $table->integer('type')->comment('领取方式 1物流 2到店');
            $table->integer('gl_id')->nullable()->comment('到店领取(线下活动领取) 活动id');
            $table->timestamp('deliver_time')->nullable()->comment('发货时间');
            $table->timestamp('complete_time')->nullable()->comment('收货时间/领取时间');
            $table->integer('e_id')->nullable()->comment('物流公司id');
            $table->string('e_order')->nullable()->comment('物流单号');
            $table->text('e_text')->nullable()->comment('物流信息');
            $table->timestamp('automatic_time')->nullable()->comment('系统自动确认时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_orders');
    }
}
