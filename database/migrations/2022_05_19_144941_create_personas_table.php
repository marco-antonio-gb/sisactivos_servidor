<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id('idPersona');
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('nombres');
            $table->string('ci')->nullable()->unique();
            $table->string('ci_ext')->nullable();
            $table->string('direccion')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefono')->nullable();
            $table->string('foto')->nullable();
            $table->string('cargo')->nullable();
            $table->string('correo')->nullable()->unique();
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
        Schema::dropIfExists('personas');
    }
}
