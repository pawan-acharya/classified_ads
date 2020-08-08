<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();

            $table->string('category')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('interior_color')->nullable();
            $table->string('number_of_places')->nullable();
            $table->string('engine')->nullable();
            $table->string('cylinder')->nullable();
            $table->string('transmission')->nullable();
            $table->string('motor_skills')->nullable();
            $table->string('current_mileage')->nullable();

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
        Schema::dropIfExists('ads');
    }
}
