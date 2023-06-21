<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bank', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('bank_email');
            $table->string('bank_phone_numebr');
            $table->string('website');
            $table->string('msa_code');
            $table->unsignedBigInteger('state');
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
        Schema::dropIfExists('customer_bank');
    }
}
