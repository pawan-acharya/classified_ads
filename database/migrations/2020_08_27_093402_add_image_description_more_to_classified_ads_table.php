<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageDescriptionMoreToClassifiedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classified_ads', function (Blueprint $table) {
            $table->text('title_image')->nullable();
            $table->json('alt_images')->nullable();
            $table->json('descriptions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classified_ads', function (Blueprint $table) {
            $table->dropColumn(['title_image', 'alt_images', 'descriptions']);
        });
    }
}
