<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('blp_payment', function (Blueprint $table) {
            $table->integer('nb_address');
            $table->string('id_key')->index();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated')->nullable();
        });
        */
        Schema::drop('blp_payment');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blp_payment');
    }
}
