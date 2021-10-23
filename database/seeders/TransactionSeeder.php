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
        \DB::table('transactions')->insert([
            'total'         => 10,
            'notes'         => 'Test 1',
            'date'          => now(),
            'type'          => '+',
            'category_id'   => 1,
            'state_id'      => 2,
            'timing_id'     => 1,
            'method_id'     => 2,
            'created_at'    => now()
        ]);

        \DB::table('transactions')->insert([
            'total'         => 35.4,
            'notes'         => 'Test 2',
            'date'          => now(),
            'type'          => '+',
            'category_id'   => 1,
            'state_id'      => 2,
            'timing_id'     => 1,
            'method_id'     => 2,
            'created_at'    => now()
        ]);

        \DB::table('transactions')->insert([
            'total'         => 50,
            'notes'         => 'Test 3',
            'date'          => now(),
            'type'          => '-',
            'category_id'   => 1,
            'state_id'      => 2,
            'timing_id'     => 1,
            'method_id'     => 2,
            'created_at'    => now()
        ]);

        \DB::table('transactions')->insert([
            'total'         => 12,
            'notes'         => 'Test 4',
            'date'          => now(),
            'type'          => '+',
            'category_id'   => 1,
            'state_id'      => 2,
            'timing_id'     => 1,
            'method_id'     => 2,
            'created_at'    => now()
        ]);
    }
}
