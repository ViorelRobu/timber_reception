<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToReceptionCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reception_committee', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('active');

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
        Schema::table('reception_committee', function (Blueprint $table) {
            $table->dropForeign('reception_committee_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
