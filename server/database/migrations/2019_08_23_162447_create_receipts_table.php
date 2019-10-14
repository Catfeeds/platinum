<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('buy_time')->nullable()->comment('购买时间');
            $table->double('buy_money',15,2)->comment('购买金额');
            $table->string('model',20)->comment('购买品类');
            $table->string('brand',20)->comment('购买品牌');
            $table->string('text')->nullable()->comment('购买理由');
            $table->string('receipt_img')->comment('小票照片');
            $table->string('product_img')->comment('产品照片');
            $table->integer('u_id')->comment('用户id');
            $table->integer('is_exper')->comment('是否体验AR 1是 2否');
            $table->integer('state')->comment('状态 1审核中 2审核通过 3审核失败');
            $table->string('fail_reason')->nullable()->comment('失败原因');
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
        Schema::dropIfExists('receipts');
    }
}
