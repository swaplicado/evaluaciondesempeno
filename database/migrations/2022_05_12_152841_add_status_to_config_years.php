<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToConfigYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_years', function (Blueprint $table) {
            $table->bigInteger('status_id')->unsigned()->after('year')->default(1);

            $table->foreign('status_id')->references('id_status')->on('config_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_years', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
}
