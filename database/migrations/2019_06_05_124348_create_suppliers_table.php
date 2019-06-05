<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fibu');
            $table->string('name');
            $table->string('cui')->nullable();
            $table->string('j')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('supplier_group_id');
            $table->unsignedBigInteger('supplier_status_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('supplier_group_id')->references('id')->on('supplier_group');
            $table->foreign('supplier_status_id')->references('id')->on('supplier_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
