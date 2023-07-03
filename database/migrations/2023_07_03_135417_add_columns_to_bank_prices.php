<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBankPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_prices', function (Blueprint $table) {
            $table->double('change')->nullable()->after('rate');
            $table->double('current_rate')->nullable()->after('rate');
            $table->double('previous_rate')->nullable()->after('rate');
            $table->decimal('rate')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_prices', function (Blueprint $table) {
            $table->dropColumn('change');
            $table->dropColumn('current_rate');
            $table->dropColumn('previous_rate');
        });
    }
}
