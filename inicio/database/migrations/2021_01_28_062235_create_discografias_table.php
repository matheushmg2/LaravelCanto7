<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discografias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discografica_genero_id'); // Nome
            $table->string('nome_album');
            $table->bigInteger('album');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('discografica_genero_id')->references('id')->on('discografica_generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discografias');
    }
}
