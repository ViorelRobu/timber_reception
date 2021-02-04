<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVolumAvizLengthInNirDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nir_details', function (Blueprint $table) {
            $table->decimal('volum_aviz', 10, 6)->change();
            $table->decimal('volum_receptionat', 6, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nir_details', function (Blueprint $table) {
            $table->decimal('volum_aviz', 6, 3)->change();
            $table->decimal('volum_receptionat', 6, 3)->change();
        });
    }
}
