<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('店铺名称');
            $table->integer('delete')->default(2)->comment('是否删除 1是 2否');
            $table->integer('province')->nullable()->comment('省');
            $table->integer('city')->nullable()->comment('市');
            $table->integer('area')->nullable()->comment('区');
            $table->string('addr')->nullable()->comment('详细地址');
            $table->string('lat',30)->nullable()->comment('纬度');
            $table->string('lng',30)->nullable()->comment('经度');
            $table->unsignedInteger('voucher_num')->comment('注册电子券领取剩余数量');
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
        Schema::dropIfExists('stores');
    }
}
