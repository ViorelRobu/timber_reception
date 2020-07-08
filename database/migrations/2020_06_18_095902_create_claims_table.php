<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('company_id');
            $table->date('claim_date');
            $table->text('nir');
            $table->string('defects');
            $table->double('claim_amount', 6, 3);
            $table->double('claim_value', 8, 2);
            $table->string('claim_currency');
            $table->unsignedBigInteger('claim_status_id');
            $table->text('observations')->nullable();
            $table->text('resolution')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
            $table->foreign('claim_status_id')->references('id')->on('claim_status')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('company_id')->references('id')->on('company_info')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claims');
    }
}
