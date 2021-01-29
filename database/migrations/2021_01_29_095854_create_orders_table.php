<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_info_id');
            $table->string('order');
            $table->year('order_year');
            $table->date('order_date');
            $table->unsignedBigInteger('supplier_id');
            $table->string('destination');
            $table->string('delivery_term');
            $table->timestamps();

            $table->unique(['company_info_id', 'order', 'order_year']);
            $table->foreign('company_info_id')->references('id')->on('company_info')->onDelete('restrict');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
