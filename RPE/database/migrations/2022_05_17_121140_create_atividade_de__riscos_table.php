<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadeDeRiscosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividade_de__riscos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('situacao_aprv')->default(false);
            $table->boolean('situacao_rprv')->default(false);
            $table->date('data_inicio');
            $table->date('data_final');
            $table->text('descricao');
            $table->text('gerente');
            //$table->text('Aprovador');  
            $table->unsignedInteger('proprietario_id');
            $table->text('nome_proprietario');
            $table->timestamp('data_situacao')->default(\DB::raw('CURRENT_TIMESTAMP'));//lidar na aprovaçao
            $table->text('dias');
            $table->text('tags_natureza');
            $table->text('tags_area');
            $table->text('tags_locais');
            $table->text('tags_participantes');
            $table->unsignedInteger('id_user_aprovacao')->default(0);
            $table->text('user_aprovacao');
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
        Schema::dropIfExists('atividade_de__riscos');
    }
}
