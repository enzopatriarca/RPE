<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_atividades', function (Blueprint $table) {
            $table->unsignedBigInteger('local_de_atividade_id');
            $table->unsignedBigInteger('atividade_de__risco_id');

            $table->foreign('local_de_atividade_id')->references('id')->on('locals')->onDelete('cascade');
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
        Schema::dropIfExists('local_atividades');
    }
}
