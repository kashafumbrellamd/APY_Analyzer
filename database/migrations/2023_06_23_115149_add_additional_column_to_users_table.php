<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('designation')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('gender')->nullable();
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
            $table->dropColumn('phone_number');
            $table->dropColumn('bank_id');
            $table->dropColumn('designation');
            $table->dropColumn('employee_id');
            $table->dropColumn('gender');
        });
    }
}
