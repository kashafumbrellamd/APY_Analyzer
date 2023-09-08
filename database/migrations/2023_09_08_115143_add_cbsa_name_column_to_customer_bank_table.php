<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCbsaNameColumnToCustomerBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_bank', function (Blueprint $table) {
            $table->string('cbsa_name')->after('cbsa_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_bank', function (Blueprint $table) {
            $table->dropColumn('cbsa_name');
        });
    }
}
