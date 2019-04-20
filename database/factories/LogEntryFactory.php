<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\LogEntry::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()
    ];
});
