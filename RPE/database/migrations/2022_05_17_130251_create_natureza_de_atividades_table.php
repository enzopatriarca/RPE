<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaturezaDeAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('natureza_de_atividades', function (Blueprint $table) {
            $table->unsignedBigInteger('natureza_de_atividade_id');
            $table->unsignedBigInteger('atividade_de__risco_id');

            $table->foreign('natureza_de_atividade_id')->references('id')->on('natureza_atividades')->onDelete('cascade');
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
        Schema::dropIfExists('natureza_de_atividades');
    }
}
