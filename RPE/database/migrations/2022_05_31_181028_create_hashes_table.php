<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('atividade_de__risco_id');
            $table->string('hash_aprv');
            $table->string('hash_rprv');
            $table->timestamps();
            $table->foreign('atividade_de__risco_id')->references('id')->on('atividade_de__riscos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hashes');
    }
}
