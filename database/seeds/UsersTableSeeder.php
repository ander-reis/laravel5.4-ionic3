<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeFlix\Models\User::class, 20)
            ->states('admin')
            ->create()->each(function ($user){
                $user->verified = true;
                $user->save();
            });

        factory(\CodeFlix\Models\User::class, 1)->create([
            'name' => 'Anderson Reis',
            'email' => 'ander-reis@hotmail.com',
            'password' => bcrypt('secret'),
            'verified' => 1,
            'remember_token' => str_random(10),
        ]);
    }
}
