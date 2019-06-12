<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
	return [
			   'title' => rtrim($faker->sentence(rand(5,10)),"."), //reduzir a frase e retirar o ponto final
			    'body' => $faker->paragraphs(rand(3,7),true),
			    'views' => rand(0,10),
			    //'answers_count' => rand(0,10),
			    'votes' => rand(-3,10)
			];
});