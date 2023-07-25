<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCustomerBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_bank', function (Blueprint $table) {
            $table->string('cbsa_code')->after('charity_id')->nullable();
            $table->string('zip_code')->after('msa_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_banks', function (Blueprint $table) {
            $table->dropColumn('cbsa_code');
            $table->dropColumn('zip_code');
        });
    }
}
