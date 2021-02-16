<?php

namespace Oka6\DouApi\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Oka6\Admin\Helper\Helper;
use Oka6\Admin\Library\MongoUtils;
use Oka6\Admin\Models\Sequence;

class Notification extends Model {
	const TABLE = 'notification';
	protected $fillable = [
		'status',
		'status_error',
		'notification_at',
		'subscription_id',
		'accumulated_dou_send',
		'total_dou_send',
		'ids_dou_send',
		'user_id',
		'email',
		'api',
		'filter',
		'files',
	];

	protected $table = 'notification';
	protected $connection = 'oka6_douapi';
	protected $dates = [
		'created_at',
		'updated_at',
		'notification_at',
	];
	
	protected
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	public static function scopeWithSubscription($query, $subscription){
		return $query->where('subscription_id', $subscription->_id);
	}
	
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
	public static function getLastNotification($id){
		$now = new \DateTime();
		$now->setTime(0, 0, 0);
		return self::where('subscription_id', $id)
			->where('created_at', '>=', $now)
			->orderBy('created_at', 'DESC')
			->first();
	}
	
	public static function getBy_id($_id, $userId=null){
		$query = self::query();
		if($userId){
			$query->where('user_id', (int)$userId);
		}
		return $query->where('_id',new \MongoDB\BSON\ObjectId($_id))->first();
	}
	
	public static function createSendPdf($status, $statusError, $subscription, $files, $user){
		$dataSave = [
			'status'=>$status,
			'status_error'=>$statusError,
			'notification_at'=> MongoUtils::convertDatePhpToMongo(date('Y-m-d H:i:s')),
			'subscription_id'=>$subscription->_id,
			'accumulated_dou_send'=>1,
			'total_dou_send'=>0,
			'ids_dou_send'=>[],
			'user_id'=>(int)$user->id,
			'email'=>$subscription->email_notify,
			'api'=>null,
			'filter'=>null,
			'files'=>$files,
		];
		self::create($dataSave);
	}
	
	public static function createSend50News($status, $statusError, $subscription, $ids, $user, $lastNotification){
		$accumulate = ($lastNotification ? $lastNotification->accumulated_dou_send+count($ids) : count($ids));
		$dataSave = [
			'status'=>$status,
			'status_error'=>$statusError,
			'notification_at'=> MongoUtils::convertDatePhpToMongo(date('Y-m-d H:i:s')),
			'subscription_id'=>$subscription->_id,
			'accumulated_dou_send'=>(int)$accumulate,
			'total_dou_send'=>0,
			'ids_dou_send'=>$ids,
			'user_id'=>(int)$user->id,
			'email'=>$subscription->email_notify,
			'api'=>null,
			'filter'=>$subscription->filter,
			'files'=>null,
		];
		self::create($dataSave);
	}
	
}
