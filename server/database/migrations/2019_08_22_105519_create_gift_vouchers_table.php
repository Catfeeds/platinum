<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('礼品名称');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->unsignedInteger('sales')->default(0)->comment('销量');
            $table->unsignedInteger('integral')->comment('兑换积分');
            $table->string('cover')->comment('封面图');
            $table->text('imgs')->comment('轮播图');
            $table->text('text')->comment('详情');
            $table->timestamp('start')->comment('兑换开始时间');
            $table->timestamp('end')->comment('兑换结束时间');
            $table->unsignedInteger('is_shelf')->default(2)->comment('是否下架 1是 2否');
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
        Schema::dropIfExists('gift_vouchers');
    }
}
