<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('微信昵称');
            $table->string('mobile',20)->unique();
            $table->string('password');
            $table->string('member_nickname',30)->nullable()->comment('会员昵称');
            $table->string('avatarurl')->comment('用户头像');
            $table->string('xcx_openid',50)->comment('小程序openid');
            $table->unsignedInteger('integral')->default(0)->comment('用户积分');
            $table->string('country',50)->nullable()->comment('国家');
            $table->string('province',50)->nullable()->comment('省份');
            $table->string('city',50)->nullable()->comment('城市');
            $table->string('area',50)->nullable()->comment('地区');
            $table->string('addr')->nullable()->comment('详细地址');
            $table->string('zip',10)->nullable()->comment('邮编');
            $table->string('email',30)->nullable()->comment('邮箱');
            $table->string('member_no',40)->comment('会员编号');
            $table->timestamp('first_sales_date')->nullable()->comment('首次购买');
            $table->integer('tier')->comment('会员等级');
            $table->timestamp('upgrade_date')->nullable()->comment('升级降级日期');
            $table->string('get_info_by_sms')->default(1)->comment('是否愿意接受短信 1是 2否');
            $table->string('source')->nullable()->comment('来源');
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
        Schema::dropIfExists('users');
    }
}
