<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingPerSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_per_supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('subgroup_id');
            $table->text('unitate');
            $table->double('greutate', 8, 3);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('subgroup_id')->references('id')->on('packaging_subgroup')->onDelete('restrict');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
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
        Schema::dropIfExists('packaging_per_supplier');
    }
}
