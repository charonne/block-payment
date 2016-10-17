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
        Schema::drop('blp_payment');
        
        Schema::create('blp_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('nb_address');
            $table->string('id_key')->index();
            $table->string('nb_participant');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('status');
        });
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
