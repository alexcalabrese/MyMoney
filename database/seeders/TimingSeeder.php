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
            'icon' => 'pi pi-fw pi-calendar',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Giornaliera',
            'icon' => 'pi pi-fw pi-briefcase',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Settimanale',
            'icon' => 'pi pi-fw pi-bookmark',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Mensile',
            'icon' => 'pi pi-fw pi-apple',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Trimestrale',
            'icon' => 'pi pi-fw pi-compass',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Semestrale',
            'icon' => 'pi pi-fw pi-comment',
            'created_at' => now()
        ]);

        \DB::table('timings')->insert([
            'name' => 'Annuale',
            'icon' => 'pi pi-fw pi-camera',
            'created_at' => now()
        ]);
    }
}
