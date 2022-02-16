<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'karina.barrera',
            'email' => 'recepción@aeth.mx',
            'password' => bcrypt('karina.barrera')
        ]);
        DB::table('users')->insert([
            'name' => 'adolfo.elizarraras',
            'email' => 'aelizarraras@aeth.mx',
            'password' => bcrypt('adolfo.elizarraras')
        ]);
        

    }
}
