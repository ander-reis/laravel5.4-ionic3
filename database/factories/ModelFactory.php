<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\CodeFlix\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

//Factory de users
$factory->state(\CodeFlix\Models\User::class, 'admin', function (Faker\Generator $faker) {
    static $password;

    return [
        'role' => \CodeFlix\Models\User::ROLE_ADMIN,
    ];
});
//Factory de Categorias
$factory->define(\CodeFlix\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'category' => $faker->unique()->word
    ];
});

//Factory de Categorias
$factory->define(\CodeFlix\Models\Serie::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'thumb' => 'thumb.jpg',
    ];
});

//Factory de Videos
$factory->define(\CodeFlix\Models\Video::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'duration' => rand(1,30),
        'file' => 'file.jpg',
        'thumb' => 'thumb.jpg',
        'published' => rand(0,1),
        'completed' => 0
    ];
});

//factory plan
$factory->define(\CodeFlix\Models\Plan::class, function (\Faker\Generator $faker){
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'value' => $faker->randomFloat(2, 50, 100)
    ];
});

$factory->state(\CodeFlix\Models\Plan::class, \CodeFlix\Models\Plan::DURATION_MONTHLY, function (){
    return [
        'duration' => \CodeFlix\Models\Plan::DURATION_MONTHLY
    ];
});

$factory->state(\CodeFlix\Models\Plan::class, \CodeFlix\Models\Plan::DURATION_YEARLY, function (){
    return [
        'duration' => \CodeFlix\Models\Plan::DURATION_YEARLY
    ];
});

//order
$factory->define(\CodeFlix\Models\Order::class, function(\Faker\Generator $faker){
    return [
        'code' => str_random(),
        'value' => $faker->randomFloat(2, 50, 100)
    ];
});

//subscription
$factory->define(\CodeFlix\Models\Subscription::class, function(\Faker\Generator $faker){
    return [
        'plan_id' => 1,
        'order_id' => 1,
        'expires_at' => '2018-12-31',
        'created_at' => $faker->date('Y-m-d', 'now'),
        'updated_at' => $faker->date('Y-m-d', 'now'),
    ];
});

$factory->define(\CodeFlix\Models\PayPalWebProfile::class, function (\Faker\Generator $faker){
    return [
        'name' => $faker->name,
        'logo_url' => $faker->imageUrl(50, 50),
        'code' => str_random()
    ];
});