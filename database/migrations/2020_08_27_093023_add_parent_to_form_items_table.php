<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentToFormItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_items', function (Blueprint $table) {
            $table->unsignedBigInteger('parent')->nullable();
            $table->foreign('parent')->references('id')->on('form_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_items', function (Blueprint $table) {
            $table->dropForeign('form_items_parent_foreign');
            $table->dropColumn('parent');
        });
    }
}
