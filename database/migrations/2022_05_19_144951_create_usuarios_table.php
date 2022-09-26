<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('idUsuario');  
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('nombres');
            $table->string('ci')->nullable()->unique();
            $table->string('ci_ext')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable()->unique();
            $table->string('foto')->nullable();
            $table->string('cargo')->nullable();
            $table->string('correo')->nullable()->unique();          
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('estado')->nullable()->default(true);
            
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
        Schema::dropIfExists('usuarios');
    }
}
