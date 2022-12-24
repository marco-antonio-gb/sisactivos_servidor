<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_transferencias', function (Blueprint $table) {
            $table->id('idDetalleTransferencia');
            $table->string('detalle')->nullable();
            $table->timestampTz('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('transferencia_id')->nullable();
            $table->foreign('transferencia_id')->references('idTransferencia')->on('transferencias')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_transferencias');
    }
}
