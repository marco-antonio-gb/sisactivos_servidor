<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgFinancierosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_financieros', function (Blueprint $table) {
            $table->id('idOrgfinanciero');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(true);
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
        Schema::dropIfExists('org_financieros');
    }
}
