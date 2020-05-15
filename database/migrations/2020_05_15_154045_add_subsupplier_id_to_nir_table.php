<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubsupplierIdToNirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nir', function (Blueprint $table) {
            $table->unsignedBigInteger('subsupplier_id')->after('supplier_id');
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
            $table->dropColumn('subsupplier_id');
        });
    }
}
