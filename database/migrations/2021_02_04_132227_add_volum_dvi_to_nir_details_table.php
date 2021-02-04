<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVolumDviToNirDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nir_details', function (Blueprint $table) {
            $table->decimal('volum_dvi', 6, 2)->after('volum_aviz');
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
            $table->dropColumn('volum_dvi');
        });
    }
}
