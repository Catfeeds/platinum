<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('名称');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->unsignedInteger('sales')->default(0)->comment('销量');
            $table->integer('type')->comment('券分类id');
            $table->unsignedInteger('integral')->comment('兑换积分');
            $table->string('cover')->comment('封面图');
            $table->text('imgs')->comment('轮播图');
            $table->text('text')->comment('详情');
            $table->text('rule')->nullable()->comment('使用规则');
            $table->timestamp('start')->comment('兑换开始时间');
            $table->timestamp('end')->comment('兑换结束时间');
            $table->unsignedInteger('is_shelf')->default(2)->comment('是否下架 1是 2否');
            $table->string('full_name')->nullable()->comment('全称');
            $table->integer('is_regist')->default(0)->comment('是否注册使用(全局只有一个1) 0否 1是');
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
        Schema::dropIfExists('vouchers');
    }
}
