<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayReportsColumnToCustomerBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_bank', function (Blueprint $table) {
            $table->enum('display_reports',['state','msa','custom']);
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
            $table->dropColumn('display_reports');
        });
    }
}
