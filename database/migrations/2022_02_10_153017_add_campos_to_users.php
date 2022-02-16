<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('num_employee')->after('email');
            $table->string('firt_name',100);
            $table->string('last_name',100);
            $table->string('full_name',100);
            $table->boolean('is_active');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('job_id');
            $table->integer('external_id');
            $table->boolean('is_delete');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            $table->foreign('department_id')->references('id_department')->on('ext_departments');
            $table->foreign('job_id')->references('id_job')->on('jobs');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
