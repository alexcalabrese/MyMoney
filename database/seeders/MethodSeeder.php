<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('methods')->insert([
            'name' => 'Contanti',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Carta di credito',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Trasferimento',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Buono',
            'created_at' => now()
        ]);
    }
}
