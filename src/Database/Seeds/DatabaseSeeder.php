<?php

namespace Oka6\DouApi\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(ResourceTableSeed::class);
		$this->call(PlanTableSeed::class);
	}
}
