<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_status', function (Blueprint $table) {
            $table->bigIncrements('id_status');
            $table->String('status');
        });

        $values = [['Nuevo'], ['Abierto'], ['Cerrado']];
        foreach($values as $v){
            $id = DB::table('config_status')->insertGetId(
                array(
                    'status' => $v[0],
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_status');
    }
}
