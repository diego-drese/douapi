<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 15/08/18
 * Time: 15:10
 */
return [
	'oka6_douapi' => [
		'driver' => 'mongodb',
		'host' => env('OKA6_DOUAPI_DB_HOST', '127.0.0.1'),
		'port' => env('OKA6_DOUAPI_DB_PORT', 27017),
		'database' => env('OKA6_DOUAPI_DB_NAME', 'oka6_douapi'),
		'username' => env('OKA6_DOUAPI_DB_USERNAME', ''),
		'password' => env('OKA6_DOUAPI_DB_PASSWORD', ''),
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => '',
		'strict' => false,
		'engine' => null,
		'options' => [
			'db' => 'admin' // sets the authentication database required by mongo 3
		]
	]
];
