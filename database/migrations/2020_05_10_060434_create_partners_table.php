<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            $table->string('business_name');
            $table->string('first_name');
            $table->string('name');
            $table->string('home_phone');
            $table->string('mobile_phone');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->enum('correspondence_language',['English', 'French']);
            $table->longText('security_question')->nullable();
            $table->longText('security_answer')->nullable();
            $table->string('email');
            $table->string('heard_about')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected']);
            $table->unsignedBigInteger('user_id');
            
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('partners');
    }
}
