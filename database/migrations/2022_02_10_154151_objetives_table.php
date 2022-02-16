<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ObjetivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetives', function (Blueprint $table) {
            $table->bigIncrements('id_objetive');
            $table->unsignedBigInteger('eval_id');
            $table->string('name');
            $table->string('activities');
            $table->string('comment');
            $table->integer('weighing');
            $table->unsignedBigInteger('score_id');
            $table->integer('is_deleted');
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
