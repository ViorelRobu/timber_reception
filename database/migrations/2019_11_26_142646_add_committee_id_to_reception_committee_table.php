<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommitteeIdToReceptionCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reception_committee', function (Blueprint $table) {
            $table->unsignedBigInteger('committee_id')->after('company_id');

            $table->foreign('committee_id')->references('id')->on('committee')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reception_committee', function (Blueprint $table) {
            $table->dropForeign(['committee_id']);
            $table->dropColumn('committee_id');
        });
    }
}
