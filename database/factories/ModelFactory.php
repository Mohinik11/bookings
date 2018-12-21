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
$autoIncrementer = autoIncrementer();
$factory->define(App\Customer::class, function (Faker\Generator $faker) use ($autoIncrementer) {
    $autoIncrementer->next();
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => password_hash('123456', PASSWORD_BCRYPT),
        'bonus_points' => $faker->valid()->passthrough(mt_rand(200, 800)),
        'updated_by' => $faker->valid()->passthrough(mt_rand(1, 10)),
        'generate_id' => $faker->randomElement([
                    'asdfwe',
                    'awerty',
                    'qwedse',
                    'rtyui',
                ]) . $autoIncrementer->current(),
    ];
});

$factory->define(App\Room::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement([
                    'Economy Single Room',
                    'Economy Double Room',
                    'Luxury Single Room',
                    'Luxury Double Room',
                    'Family Suite',
                ]),
        'required_points' => $faker->valid()->passthrough(mt_rand(0, 400)),
        'available_amount' => $faker->valid()->passthrough(mt_rand(0, 100)),
    ];
});

$factory->define(App\Booking::class, function (Faker\Generator $faker) {
    return [
        'customer_id' => $faker->valid()->passthrough(mt_rand(1, 10)),
        'room_id' => $faker->valid()->passthrough(mt_rand(1, 5)),
        'status' => $faker->randomElement([
                    'RESERVED',
                    'PENDING_APPROVAL'
                ]),
    ];
});

function autoIncrementer()
{
    for ($i = 0; $i < 100; $i++) {
        yield $i;
    }
}
