<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('idReporte');
            $table->string('nombre');
            $table->string('archivo');
            $table->string('url');
            $table->string('tipo');
            $table->unsignedBigInteger('asignacion_id')->nullable();
            $table->foreign('asignacion_id')->references('idAsignacion')->on('asignaciones')->onDelete('set null');
            $table->unsignedBigInteger('transferencia_id')->nullable();;
            $table->foreign('transferencia_id')->references('idTransferencia')->on('transferencias')->onDelete('set null');
            $table->unsignedBigInteger('baja_id')->nullable();;
            $table->foreign('baja_id')->references('idBaja')->on('bajas')->onDelete('set null');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('idUsuario')->on('usuarios')->onDelete('set null');
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
        Schema::dropIfExists('reportes');
    }
}
