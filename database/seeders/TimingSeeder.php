<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TimingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('timings')->insert([
            'name' => 'One Time',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Giornaliera',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Settimanale',
            'created_at' => now()
        ]);
        
        \DB::table('timings')->insert([
            'name' => 'Mensile',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Trimestrale',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Semestrale',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Annuale',
            'created_at' => now()
        ]);

        

        


        

        
    }
}
