<?php
return [
	'public_key' =>  env('STRIPE_KEY_PUBLIC', '0'),
	'secret_key' => env('STRIPE_KEY_SECRET', '0'),
	'webhook_key' => env('STRIPE_KEY_WEBHOOK', '0'),
];
