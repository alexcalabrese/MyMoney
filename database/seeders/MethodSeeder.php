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
            'icon' => 'pi pi-fw pi-bookmark',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Carta di credito',
            'icon' => 'pi pi-fw pi-apple',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Trasferimento',
            'icon' => 'pi pi-fw pi-compass',
            'created_at' => now()
        ]);

        \DB::table('methods')->insert([
            'name' => 'Buono',
            'icon' => 'pi pi-fw pi-comment',
            'created_at' => now()
        ]);
    }
}
