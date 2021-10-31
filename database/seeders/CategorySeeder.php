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
            'icon' => 'pi pi-fw pi-calendar',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Shopping',
            'icon' => 'pi pi-fw pi-briefcase',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Casa',
            'icon' => 'pi pi-fw pi-bookmark',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Transporti',
            'icon' => 'pi pi-fw pi-apple',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Veicoli',
            'icon' => 'pi pi-fw pi-compass',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Intrattenimento',
            'icon' => 'pi pi-fw pi-comment',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Comunicazione, PC',
            'icon' => 'pi pi-fw pi-camera',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Spese finanziarie',
            'icon' => 'pi pi-fw pi-cog',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Investimenti',
            'icon' => 'pi pi-fw pi-discord',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Introiti',
            'icon' => 'pi pi-fw pi-eject',
            'created_at' => now()
        ]);

        \DB::table('categories')->insert([
            'name' => 'Altro',
            'icon' => 'pi pi-fw pi-eye',
            'created_at' => now()
        ]);
    }
}
