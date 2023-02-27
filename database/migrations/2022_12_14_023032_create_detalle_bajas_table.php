<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleBajasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_bajas', function (Blueprint $table) {
			$table->id('idDetalleBaja');
			$table->string('motivo')->nullable();
			$table->string('informebaja')->nullable();
			$table->string('archivo_informebaja')->nullable();
			$table->timestampTz('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->unsignedBigInteger('baja_id')->nullable();
			$table->foreign('baja_id')->references('idBaja')->on('bajas')->onDelete('cascade');
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
		Schema::dropIfExists('detalle_bajas');
	}
}
