<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('labels')->insert([
            'name' => 'A Carico Famiglia',
            'created_at' => now()
        ]);

        \DB::table('labels')->insert([
            'name' => 'Spesa Extra Risparmio',
            'created_at' => now()
        ]);

        \DB::table('labels')->insert([
            'name' => 'Spesa Personale',
            'created_at' => now()
        ]);
    }
}
