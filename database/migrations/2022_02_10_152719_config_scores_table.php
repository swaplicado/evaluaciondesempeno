<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConfigScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_scores', function (Blueprint $table) {
            $table->bigIncrements('id_score');
            $table->string('name',100);
            $table->integer('weighing');
            $table->boolean('is_deleted');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
        /*
        DB::table('sys_eval_status')->insert([
        	['id_score' => '1','name' => 'NA', 'weighing' => '0', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
        	['id_score' => '2','name' => 'No cumplió', 'weighing' => '1', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
            ['id_score' => '3','name' => 'Cumplió con reservas', 'weighing' => '2', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
            ['id_score' => '4','name' => 'Cumplió', 'weighing' => '3', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
            ['id_score' => '5','name' => 'Supero expectativas', 'weighing' => '4', 'is_delete' => 0 , 'created_by' => '1', 'updated_by' => '1' ],
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
        Schema::dropIfExists('config_scores_table');
    }
}
