<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ext_departments', function (Blueprint $table) {
            $table->bigIncrements('id_department');
            $table->string('name',100);
            $table->string('abbreviation',50);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->integer('external_id');
            $table->boolean('is_delete');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('department_id')->references('id_department')->on('ext_departments');
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
        Schema::dropIfExists('ext_departments');
    }
}
