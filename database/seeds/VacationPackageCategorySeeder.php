<?php

use Illuminate\Database\Seeder;

class VacationPackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vacation_package_categories')->insert([
            'name' => 'SPA paketid'
        ]);

        DB::table('vacation_package_categories')->insert([
            'name' => 'Perepuhkus'
        ]);

        DB::table('vacation_package_categories')->insert([
            'name' => 'Romantikapakett'
        ]);

        DB::table('vacation_package_categories')->insert([
            'name' => 'Kultuur'
        ]);

        DB::table('vacation_package_categories')->insert([
            'name' => 'Aktiivne puhkus'
        ]);
    }
}
