<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->comment('订单号');
            $table->integer('v_id')->comment('券id');
            $table->integer('v_type')->comment('券分类id');
            $table->integer('num')->comment('券数量');
            $table->integer('integral')->comment('订单总积分');
            $table->integer('u_id')->comment('用户id');
            $table->integer('state')->comment('状态 1待核销 2已核销 3已失效');
            $table->integer('write_u_id')->nullable()->comment('核销人员id');
            $table->timestamp('expiring_time')->nullable()->comment('失效时间');
            $table->timestamp('write_time')->nullable()->comment('核销时间');
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
        Schema::dropIfExists('voucher_order');
    }
}
