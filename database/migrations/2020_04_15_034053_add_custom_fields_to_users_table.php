<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('correspondence_language',['English', 'French'])->default('French');
            $table->longText('security_question')->nullable();
            $table->longText('security_answer')->nullable();
            $table->string('heard_about')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('home_phone');
            $table->dropColumn('mobile_phone');
            $table->dropColumn('city');
            $table->dropColumn('province');
            $table->dropColumn('postal_code');
            $table->dropColumn('correspondence_language');
            $table->dropColumn('security_question');
            $table->dropColumn('security_answer');
            $table->dropColumn('heard_about');
        });
    }
}
