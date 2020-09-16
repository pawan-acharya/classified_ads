<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeValidateDateToClassifiedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classified_ads', function (Blueprint $table) {
            $table->enum('feature_type', ['day', 'week', 'month'])->default('day');
            $table->date('validated_date')->nullable();
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
            $table->dropColumn(['feature_type', 'validated_date']);
        });
    }
}
