<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->text('position');
            $table->float('ordered_volume', 8, 3);
            $table->float('price', 5, 2);
            $table->string('currency');
            $table->float('confirmed_volume', 8, 3);
            $table->float('delivered_volume', 8, 3);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
