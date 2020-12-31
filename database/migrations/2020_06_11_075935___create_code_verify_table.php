<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeVerifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_verifies',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->char('code_verify_login')->default(0);
            $table->char('code_verify_register')->default(0);
            $table->dateTime('expired_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_verifies');
    }
}
