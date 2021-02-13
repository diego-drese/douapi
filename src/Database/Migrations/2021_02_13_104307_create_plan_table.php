<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreatePlanTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	protected $connection = 'oka6_douapi';
	public function up() {
		Schema::connection($this->connection)->table('plan', function (Blueprint $table) {
			$table->background('name');
			$table->background('status');
			$table->background('email_notify'); //disable notify apis
			$table->background('api_notify'); // disable Notify emails
			
			$table->background('notify_email_pdf');
			$table->background('notify_email_50_news'); //Req filter
			
			
			$table->background('notify_api_xml'); // Disable filter
			$table->background('notify_api_all_news');// Disable filter
			
			$table->background('notify_api_50_news'); //Req filter
			$table->background('notify_api_100_news'); //Req filter
			$table->background('notify_api_200_news'); //Req filter
			$table->background('notify_api_400_news'); //Req filter
			
			$table->background('stripe_id');
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
		Schema::connection($this->connection)->dropIfExists('plan');
	}
	
}
