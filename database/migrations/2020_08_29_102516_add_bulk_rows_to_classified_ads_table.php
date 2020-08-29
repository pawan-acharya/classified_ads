<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulkRowsToClassifiedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classified_ads', function (Blueprint $table) {
            $table->string('title')->nullable();
            // $table->text('description')->nullable();
            // $table->text('image')->nullable();
            $table->string('citq')->nullable();
            $table->string('price')->nullable();
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
            $table->dropColumn(['title', 'citq', 'price']);
        });
    }
}
