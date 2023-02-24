<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) 
        {
            $table->id();
            // ->unique()
            $table->string('nombre', 255)->nullable()->comment("Nombre del post");
            $table->text('slug')->nullable()->comment("Slug del post");
            $table->text('descripcion')->nullable()->comment("Descripcion del post");
            $table->boolean('publicado')->default(true)->nullable()->comment("Estado del publicado");
         
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->foreign('creado_por')->index()->references('id')->on('users')->comment("Usuario que creo el post");

            $table->dateTime('fecha_creacion')->index()->comment("Fecha de ingreso del post");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
