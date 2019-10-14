<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('u_id')->comment('用户id');
            $table->integer('age')->nullable()->comment('年龄');
            $table->string('memorial_day_name',100)->nullable()->comment('纪念日名称');
            $table->timestamp('memorial_date')->nullable()->comment('纪念日日期');
            $table->string('constellation',10)->nullable()->comment('星座');
            $table->string('referrer_name',30)->nullable()->comment('推荐人昵称');
            $table->string('referrer_mobile',11)->nullable()->comment('推荐人手机号');
            $table->timestamp('wechat_follow_date')->nullable()->comment('微信关注日');
            $table->string('job',30)->nullable()->comment('职业');
            $table->unsignedInteger('salary')->nullable()->comment('月收入');
            $table->integer('is_marr')->nullable()->comment('婚姻状态 1已婚 2未婚');
            $table->integer('is_sub')->nullable()->comment('是否有子女 1是 2否');
            $table->integer('sex')->nullable()->comment('性别 1男 2女');
            $table->string('full_name',20)->nullable()->comment('真实姓名');
            $table->timestamp('birthday')->nullable()->comment('生日');
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
        Schema::dropIfExists('user_detail');
    }
}
