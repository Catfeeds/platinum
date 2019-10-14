<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GiftVouchersAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //gift_vouchers
        Schema::table('gift_vouchers',function (Blueprint $table) {
            $table->string('full_name')->nullable()->comment('全称');
            $table->string('redeem_rule')->nullable()->comment('兑换规则');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
