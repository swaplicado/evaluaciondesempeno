<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ObjetivesStatusLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetives_status_log', function (Blueprint $table) {
            $table->bigIncrements('id_bin');
            $table->unsignedBigInteger('eval_id');
            $table->unsignedBigInteger('eval_status_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('eval_id')->references('id_eval')->on('evals');
            $table->foreign('eval_status_id')->references('id_eval_status')->on('sys_eval_status');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
