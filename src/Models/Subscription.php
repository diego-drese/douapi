<?php

namespace Oka6\DouApi\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Oka6\Admin\Helper\Helper;
use Oka6\Admin\Models\Sequence;

class Subscription extends Model {
	const TABLE = 'subscription';
	protected $fillable = [
		'status',
		'validate_at',
		'description',
		'subscription_id',
		'plan_id',
		'billing_amount',
		'plan_name',
		'user_id',
		
		'email',
		'email_notify',
		'notify_email_pdf',
		'notify_email_50_news',
		
		'api',
		'api_notify',
		'notify_api_xml',
		'notify_api_all_news',
		'notify_api_50_news',
		
		'session_id',
		'filter',
		'configured',
	];


	protected $table = 'subscription';
	protected $connection = 'oka6_douapi';
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'validate_at'
	];
	
	protected
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	public static function scopeWithUser($query, $user){
		return $query->where('user_id', (int)$user->id);
	}
	
	public static function getAllActives(){
		return self::where('status', self::STATUS_ACTIVE)->get();
	}
	
	public static function getBySessionId($id){
		return self::where('session_id', $id)->first();
	}
	public static function getBySubscriptionId($id){
		return self::where('subscription_id', $id)->first();
	}
	
	public static function getBy_id($_id, $userId=null){
		$query = self::query();
		if($userId){
			$query->where('user_id', (int)$userId);
		}
		return $query->where('_id',new \MongoDB\BSON\ObjectId($_id))->first();
	}
	
}
