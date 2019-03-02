<?php

use Faker\Generator as Faker;

$factory->define(App\PhoneNumber::class, function (Faker $faker) {
    return [
        'number' => +2347035925490,
        'notification_on' => true
    ];
});
