<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_log', function (Blueprint $table) {
            $table->bigIncrements('id_mail_log');
            $table->unsignedBigInteger('send_to');
            $table->unsignedBigInteger('evaluator');
            $table->boolean('is_send');
            $table->timestamps();

            $table->foreign('send_to')->references('id')->on('users');
            $table->foreign('evaluator')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_log');
    }
}
