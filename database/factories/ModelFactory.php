<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Channel::class, function(Faker\Generator $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(App\Thread::class, function(Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Reply::class, function(Faker\Generator $faker) {
    return [
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Activity::class, function(Faker\Generator $faker) {
    return [
        'user_id' => null,
        'type' => null,
    ];
});

// Testing

$factory->state(App\Thread::class, 'testing', function(Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'channel_id' => function() {
            return factory(App\Channel::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->state(App\Reply::class, 'testing', function(Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'thread_id' => function() {
            return factory(App\Thread::class)->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
