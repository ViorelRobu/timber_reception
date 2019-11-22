<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nir_id');
            $table->text('packaging_data');
            $table->timestamps();

            $table->foreign('nir_id')->references('id')->on('nir')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packaging_data');
    }
}
