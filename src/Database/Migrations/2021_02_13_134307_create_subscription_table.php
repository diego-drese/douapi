<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateSubscriptionTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	protected $connection = 'oka6_douapi';
	public function up() {
		Schema::connection($this->connection)->table('subscription', function (Blueprint $table) {
			$table->background('name');
			$table->background('status');
			$table->background('description');
			$table->background('plan_id');
			$table->background('user_id');
			$table->background('validate_at');
			
			$table->background('email');
			$table->background('api');
			$table->background('job');
			$table->background('filter');
			
			$table->background('created_at');
			$table->background('updated_at');
		});
		
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::connection($this->connection)->dropIfExists('subscription');
	}
	
}
