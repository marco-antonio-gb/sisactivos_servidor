<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleAsignacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_asignaciones', function (Blueprint $table) {
            $table->id('idDetalleAsignacion');
            $table->string('detalle');
            $table->timestampTz('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('asignacion_id')->nullable();
            $table->foreign('asignacion_id')->references('idAsignacion')->on('asignaciones')->onDelete('cascade');
            $table->unsignedBigInteger('articulo_id')->nullable();
            $table->foreign('articulo_id')->references('idArticulo')->on('articulos')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_asignaciones');
    }
}
