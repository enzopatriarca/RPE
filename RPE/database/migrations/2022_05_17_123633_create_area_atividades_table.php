<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_atividades', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unsignedBigInteger('area__risco_id');
            $table->unsignedBigInteger('atividade_de__risco_id');

            $table->foreign('area__risco_id')->references('id')->on('area__riscos')->onDelete('cascade');
            $table->foreign('atividade_de__risco_id')->references('id')->on('atividade_de__riscos')->onDelete('cascade');

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
        Schema::dropIfExists('area_atividades');
    }
}
