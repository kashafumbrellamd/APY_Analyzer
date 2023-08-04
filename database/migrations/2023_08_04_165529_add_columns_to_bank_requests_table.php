<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBankRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_requests', function (Blueprint $table) {
            $table->text('email')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_requests', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone_number');
            $table->text('user_id')->change();
        });
    }
}
