<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSerieAvizOnNirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nir', function (Blueprint $table) {
            $table->string('serie_aviz')->nullable()->change();
            $table->string('numar_aviz')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nir', function (Blueprint $table) {
            $table->string('serie_aviz')->change();
            $table->string('numar_aviz')->change();

        });
    }
}
