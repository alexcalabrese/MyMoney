<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::factory()
        //     ->count(50)
        //     ->create();
        
        \DB::table('categories')->insert([
            'name' => 'Cibo e Bevande',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Shopping',
            'created_at' => now()
        ]);
        
        \DB::table('categories')->insert([
            'name' => 'Casa',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Transporti',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Veicoli',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Intrattenimento',
            'created_at' => now()
        ]);
        
        \DB::table('categories')->insert([
            'name' => 'Comunicazione, PC',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Spese finanziarie',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Investimenti',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Introiti',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Altro',
            'created_at' => now()
        ]);
    }
}
