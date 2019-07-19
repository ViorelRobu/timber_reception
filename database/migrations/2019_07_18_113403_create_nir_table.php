<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nir', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->integer('numar_nir');
            $table->date('data_nir');
            $table->string('numar_we')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('dvi')->nullable();
            $table->date('data_dvi')->nullable();
            $table->decimal('greutate_bruta', 8, 2)->nullable();
            $table->decimal('greutate_neta', 8, 2)->nullable();
            $table->string('serie_aviz');
            $table->string('numar_aviz');
            $table->date('data_aviz');
            $table->string('specificatie')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('numar_inmatriculare');
            $table->unsignedBigInteger('certification_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('company_info')->onDelete('restrict');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('restrict');
            $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nir');
    }
}
