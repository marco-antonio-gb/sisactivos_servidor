<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArhivosDetalleBajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos_detalle_baja', function (Blueprint $table) {
            $table->id('idArchivoDetallebaja');
            $table->string('nombre');
            $table->string('url');
            $table->unsignedBigInteger('detallebaja_id')->nullable();
            $table->foreign('detallebaja_id')->references('idDetalleBaja')->on('detalle_bajas')->onDelete('set null');
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
        Schema::dropIfExists('archivos_detalle_baja');
    }
}
