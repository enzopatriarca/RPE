<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('nome')->unique();
            $table->string('cargo');
            $table->string('matricula');
            $table->string('Lotacao');
            $table->integer('autorizacao');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->boolean('Aprovador')->default(false);
            //$table->unsignedInteger('Criador_user')->default(null);
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
        Schema::dropIfExists('users');
    }
}
