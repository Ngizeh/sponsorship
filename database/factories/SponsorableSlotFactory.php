<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SponsorableSlot;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(SponsorableSlot::class, function (Faker $faker) {
    return [
        'publish_date' => Carbon::now()->addMonth(1)
    ];
});
