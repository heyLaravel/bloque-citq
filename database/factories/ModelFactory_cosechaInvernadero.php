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

$factory->define(App\cosechaInvernadero::class, function (Faker\Generator $faker) {

    $siembraTransplanteInvernadero =  DB::table('siembraTransplanteInvernadero')->lists('id');
    $siembra=$faker->randomElement($siembraTransplanteInvernadero);
    $id_invernadero=DB::table('siembraTransplanteInvernadero')->where('id', $siembra)->value('id_invernadero');


    return [
        'fecha'=>$faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'),
        'comentario' => $faker->address,
        //Se abrevio siembraTransplante a st porque el nombre era muy largo y sql no lo aceptaba
        'id_stInvernadero' => $siembra,
        'id_invernadero'=>$id_invernadero


    ];
});
