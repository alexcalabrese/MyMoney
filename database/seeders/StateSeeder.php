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
            'icon' => 'pi pi-fw pi-clock',
            'created_at' => now()
        ]);

        \DB::table('states')->insert([
            'name' => 'Confermato',
            'icon' => 'pi pi-fw pi-check',
            'created_at' => now()
        ]);

        \DB::table('states')->insert([
            'name' => 'Non Confermato',
            'icon' => 'pi pi-fw pi-times',
            'created_at' => now()
        ]);
    }
}
