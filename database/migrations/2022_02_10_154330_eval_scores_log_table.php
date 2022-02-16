<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EvalScoresLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eval_scores_log', function (Blueprint $table) {
            $table->bigIncrements('id_score');
            $table->unsignedBigInteger('eval_id');
            $table->decimal('score');
            $table->unsignedBigInteger('score_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('eval_id')->references('id_eval')->on('evals');
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
        //
    }
}
