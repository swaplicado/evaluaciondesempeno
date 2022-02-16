<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysEvalStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_eval_status', function (Blueprint $table) {
            $table->bigIncrements('id_eval_status');
            $table->string('name',100);
            $table->string('abbreviation',50);
            $table->boolean('is_delete');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
        /*
        DB::table('sys_eval_status')->insert([
        	['id_eval_status' => '1','name' => 'creado', 'abbreviation' => 'CRE', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
        	['id_eval_status' => '2','name' => 'Enviado' , 'abbreviation' => 'ENV', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1'],
            ['id_eval_status' => '3', 'name' => 'rechazado' , 'abbreviation' => 'REC', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1'],
            ['id_eval_status' => '4','name' => 'Calificado', 'abbreviation' => 'CAL', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
        ]);
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_eval_status');
    }
}
