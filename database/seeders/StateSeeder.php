<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('states')->insert([
            'name' => 'Contabilizzato',
            'created_at' => now()
        ]);

        \DB::table('states')->insert([
            'name' => 'Confermato',
            'created_at' => now()
        ]);

        \DB::table('states')->insert([
            'name' => 'Non Confermato',
            'created_at' => now()
        ]);
    }
}
