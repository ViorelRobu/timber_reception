<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyOnPackagingPerSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packaging_per_supplier', function (Blueprint $table) {
            $table->dropForeign('packaging_per_supplier_supplier_id_foreign');
            $table->renameColumn('supplier_id', 'subsupplier_id');
            $table->foreign('subsupplier_id')->references('id')->on('sub_suppliers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packaging_per_supplier', function (Blueprint $table) {
            $table->dropForeign('packaging_per_supplier_subsupplier_id_foreign');
            $table->renameColumn('subsupplier_id', 'supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
        });
    }
}
