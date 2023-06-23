<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpNameToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->string('cp_phone')->nullable()->after('msa_code');
            $table->string('cp_email')->nullable()->after('msa_code');
            $table->string('cp_name')->nullable()->after('msa_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('cp_phone');
            $table->dropColumn('cp_email');
            $table->dropColumn('cp_name');
        });
    }
}
