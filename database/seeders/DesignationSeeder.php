<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Designation::factory()->count(10)->create();
    }
}
