<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNirDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nir_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nir_id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('species_id');
            $table->double('volum_aviz', 6, 2);
            $table->double('volum_receptionat', 6, 2);
            $table->unsignedBigInteger('moisture_id');
            $table->integer('pachete');
            $table->double('total_ml', 6, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nir_id')->references('id')->on('nir')->onDelete('restrict');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict');
            $table->foreign('species_id')->references('id')->on('species')->onDelete('restrict');
            $table->foreign('moisture_id')->references('id')->on('moisture')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nir_details');
    }
}
