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
            $table->integer('fibu')->unique();
            $table->string('name');
            $table->string('cui')->nullable();
            $table->string('j')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('supplier_group_id');
            $table->unsignedBigInteger('supplier_status_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
            $table->foreign('supplier_group_id')->references('id')->on('supplier_group')->onDelete('restrict');
            $table->foreign('supplier_status_id')->references('id')->on('supplier_status')->onDelete('restrict');
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
        Schema::dropIfExists('suppliers');
    }
}
