<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galerias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('nome_arquivos')->nullable();
            $table->string('tipo')->nullable();
            $table->morphs('imageble');
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
        Schema::dropIfExists('galerias');
    }
}
