<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('labels')->insert([
            'name' => 'Spesa Personale',
            'created_at' => now()
        ]);
    }
}
