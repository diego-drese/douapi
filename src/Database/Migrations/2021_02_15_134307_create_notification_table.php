<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateNotificationTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	protected $connection = 'oka6_douapi';
	public function up() {
		Schema::connection($this->connection)->table('notification', function (Blueprint $table) {
			$table->background('notification_at');
			$table->background('status');
			$table->background('subscription_id');
			$table->background('user_id');
			$table->background('email');
			$table->background('api');
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
		Schema::connection($this->connection)->dropIfExists('notification');
	}
	
}
