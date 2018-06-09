<?php

use Illuminate\Database\Seeder;

class PayPalWebProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeFlix\Models\PayPalWebProfile::class, 20)->create();
    }
}
