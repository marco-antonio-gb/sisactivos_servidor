<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id('idTransferencia');
            $table->timestampTz('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->foreign('responsable_id')->references('idResponsable')->on('responsables')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id')->nullable();
			$table->foreign('usuario_id')->references('idUsuario')->on('usuarios')->onDelete('cascade');
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
        Schema::dropIfExists('transferencias');
    }
}
