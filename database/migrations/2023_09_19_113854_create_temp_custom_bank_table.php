<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCustomBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_custom_bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('customer_bank')->onDelete('cascade');

            $table->unsignedBigInteger('customer_selected_bank_id');
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
        Schema::dropIfExists('temp_custom_bank');
    }
}
