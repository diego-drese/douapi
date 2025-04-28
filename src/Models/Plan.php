<?php

namespace Oka6\DouApi\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Oka6\DouApi\Helpers\Helper;
use Oka6\Admin\Models\Sequence;

class Plan extends Model {
	const TABLE = 'plan';
	protected $fillable = [
		'name',
		'status',
		'value',
		'email_notify',
		'api_notify',
		
		'notify_email_pdf',
		'notify_api_xml',
		'notify_email_50_news',
		'notify_api_all_news',
		'notify_api_50_news',
		'stripe_id',
		'stripe_environment',
	];

	protected $table = 'plan';
	protected $connection = 'oka6_douapi';
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	public static function makeRulesFields(){
	
	}
	public static function getAllActives(){
		return self::where('status', self::STATUS_ACTIVE)->get();
	}
	public static function getByStripeId($id){
		return self::where('stripe_id', $id)->first();
	}
	public static function getBy_id($_id){
		return self::where('_id',new \MongoDB\BSON\ObjectId($_id))->first();
	}
	
	
}
