<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_case_radiology')->unique();
            $table->integer('user_id');
            $table->string('fullname_sick');
            $table->string('code_meli_sick');
            $table->string('fullname_expert');
            $table->string('code_meli_expert');
            $table->string('cost');
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
        Schema::dropIfExists('case_files');
    }
}
