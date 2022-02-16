<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EvalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evals', function (Blueprint $table) {
            $table->bigIncrements('id_eval');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('version');
            $table->unsignedBigInteger('eval_user_id');
            $table->string('comment');
            $table->unsignedBigInteger('eval_status_id');
            $table->decimal('score');
            $table->unsignedBigInteger('score_id');
            $table->integer('is_deleted');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('year_id')->references('id_year')->on('config_years');
            $table->foreign('eval_user_id')->references('id')->on('users');
            $table->foreign('eval_status_id')->references('id_eval_status')->on('sys_eval_status');
            $table->foreign('score_id')->references('id_score')->on('config_scores');
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
        Schema::dropIfExists('evals');
    }
}
