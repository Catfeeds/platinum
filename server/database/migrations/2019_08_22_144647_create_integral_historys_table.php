<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralHistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_historys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num')->comment('变动的积分值(减积分写入负值)');
            $table->string('event',3)->comment('事件,参考积分事件文档');
            $table->string('re')->nullable()->comment('备注');
            $table->integer('u_id')->comment('会员id');
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
        Schema::dropIfExists('integral_historys');
    }
}
