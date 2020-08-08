<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('monthly_payments_before_taxes', 10, 2);
            $table->unsignedDecimal('monthly_payments_after_taxes', 10, 2);
            $table->unsignedDecimal('initial_down_payment', 10, 2);
            $table->unsignedDecimal('security_deposit', 10, 2);
            $table->unsignedDecimal('purchase_option', 10, 2);
            $table->integer('contract_kilometers')->unsigned();
            $table->unsignedDecimal('excess_mileage_fee', 10, 2);
            $table->date('contract_start_date', 0);
            $table->date('contract_end_date', 0);
            $table->integer('contract_duration')->unsigned();
            $table->unsignedDecimal('incentive_amount', 10, 2);
            $table->unsignedDecimal('deposit_amount', 10, 2);
            $table->string('transfer_fees');
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
        Schema::dropIfExists('leases');
    }
}
