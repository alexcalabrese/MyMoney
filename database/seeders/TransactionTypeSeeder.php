<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('transaction_types')->insert([
            'name' => 'Casa'
        ]);

        \DB::table('transaction_types')->insert([
            'name' => 'Cucina'
        ]);

        \DB::table('transaction_types')->insert([
            'name' => 'Affitto'
        ]);

        \DB::table('transaction_types')->insert([
            'name' => 'Shopping'
        ]);
    }
}
