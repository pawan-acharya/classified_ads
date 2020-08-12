<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser')->nullable();
            $table->foreign('advertiser')->references('id')->on('users');
            $table->unsignedBigInteger('visitor')->nullable();
            $table->foreign('visitor')->references('id')->on('users');
            $table->unsignedBigInteger('classified_ad_id')->nullable();
            $table->foreign('classified_ad_id')->references('id')->on('classified_ads');
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
        Schema::dropIfExists('chat_rooms');
    }
}
