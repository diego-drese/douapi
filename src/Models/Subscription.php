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
		'plan_id',
		'billing_amount',
		'plan_name',
		'user_id',
		'email',
		'api',
		'session_id',
		'filter',
		'job',
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
	
	
}
