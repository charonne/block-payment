<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('blp_address');
        
        Schema::create('blp_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->index();
            $table->string('bitcoin_address')->index();
            $table->string('private_key');
            $table->string('email');
            $table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blp_address');
    }
}
