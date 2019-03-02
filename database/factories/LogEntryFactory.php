<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\LogEntry::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()
    ];
});
