<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingSubgroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_subgroup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('main_id');
            $table->text('name');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('main_id')->references('id')->on('packaging_main_group')->onDelete('restrict');
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
        Schema::dropIfExists('packaging_subgroup');
    }
}
