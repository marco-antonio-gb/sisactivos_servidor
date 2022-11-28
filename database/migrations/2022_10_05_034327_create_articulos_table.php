<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idArticulo');
            $table->string('codigo');
            $table->string('unidad');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('imagen')->nullable();
            $table->decimal('costo',11,2)->default(0.00);
            $table->string('estado');
            $table->boolean('condicion')->default(true);
            $table->timestampTz('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('idCategoria')->on('categorias')->onDelete('cascade');
            $table->unsignedBigInteger('orgfinanciero_id')->nullable();
            $table->foreign('orgfinanciero_id')->references('idOrgfinanciero')->on('org_financieros')->onDelete('cascade');
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
        Schema::dropIfExists('articulos');
    }
}
