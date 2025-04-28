<?php

namespace Oka6\DouApi\Models;

use Illuminate\Support\Facades\Config;
use Jenssegers\Mongodb\Eloquent\Model;
use Oka6\DouApi\Helpers\Helper;
use Oka6\Admin\Library\MongoUtils;

class Dou extends Model {
	const TABLE = 'dou';
	const DOU_PROFILE_ID=55117744;
	protected $fillable = [
		'id',
		'name',
		'id_oficio',
		'pub_name',
		'type_id',
		'type_name',
		'date',
		'categories',
		'page_number',
		'edition_number',
		'id_materia',
		'identifica',
		'data',
		'ementa',
		'titulo',
		'sub_titulo',
		'url_dou',
		'text',
		'created_at',
		'updated_at',
	];
	
	protected $table = 'dou';
	protected $connection = 'oka6_douapi';
	protected $dates  = ['created_at', 'updated_at', 'date'];
	
	public static function getById($id){
		return self::where('id', $id)->first();
	}
	
	public static function getLastProcessed(){
		$query = self::orderBy('created_at', 'desc')->first();
		return $query ? $query->created_at->setTimeZone('America/Sao_Paulo')->format('d/m/Y H:i') : '';
	}
	
	public static function scopeWithCategories($query, $categories){
		if(!is_array($categories)){
			return $query;
		}
		return $query->whereIn('categories.id', array_map('intval', $categories));
	}
	
	public static function scopeWithTypes($query, $types){
		if(!is_array($types)){
			return $query;
		}
		return $query->whereIn('type_id', array_map('intval', $types));
	}
	public static function scopeWithSubject($query, $subject){
		if(empty($subject)){
			return $query;
		}
		return $query->where(function($q) use($subject){
			$q->where('identifica', 'like' , '%'.$subject.'%')
				->orWhere('name', 'like', '%'.$subject.'%');
		});
	}public static function scopeWithPub($query, $pub){
		if(!is_array($pub)){
			return $query;
		}
		return $query->whereIn('pub_name', array_map('strval', $pub));
	}
	
	public static function scopeWithPeriod($query, $period){
		$split = explode(' - ',$period);
		if(count($split)!=2){
			return $query;
		}
		$dateStart  = new \DateTime(Helper::convertDateBrToMysql($split[0].' 00:00:00'));
		$dateEnd    = new \DateTime(Helper::convertDateBrToMysql($split[1].' 23:59:59'));
		
		return $query->where('date', '>=', MongoUtils::convertDatePhpToMongo($dateStart))
			->where('date', '<=', MongoUtils::convertDatePhpToMongo($dateEnd));
	}
	
	public static function getBySendToEmail($filter, $notification, $limit=50){
		$query  = self::query();
		if($filter['categories'] && count($filter['categories'])){
			$ids =[];
			foreach ($filter['categories'] as $category){
				$ids[] = (int)$category['id'];
			}
			$query->whereIn('categories.id', $ids);
		}
		if($filter['type'] && count($filter['type'])){
			$ids =[];
			foreach ($filter['type'] as $type){
				$ids[] = (int)$type['id'];
			}
			$query->whereIn('type_id', $ids);
		}
		
		if($filter['subject'] && count($filter['subject'])){
			$subjects = $filter['subject'];
			$query->where(function ($query) use($subjects) {
				foreach ($subjects as  $subject){
					$query->orWhere(function($q) use($subject){
						$q->where('identifica', 'like' , '%'.$subject.'%')->orWhere('name', 'like', '%'.$subject.'%');
					});
				}
			});
		}
		
		if($filter['content'] && count($filter['content'])){
			$contents = $filter['content'];
			$query->where(function ($query) use($contents) {
				foreach ($contents as  $content){
					$query->orWhere('text', 'like', '%'.$content.'%');
				}
			});
		}
		if($filter['pub'] && count($filter['pub'])){
			$ids =[];
			foreach ($filter['pub'] as $pub){
				$ids[] = $pub;
			}
			$query->whereIn('pub_name', $ids);
		}
		
		if($notification && $notification->ids_dou_send){
			$ids = array_map(function($id) {
				return new \MongoDB\BSON\ObjectId($id);
			}, $notification->ids_dou_send);
			$query->whereNotIn('_id', $ids);
		}
		$now    = new \DateTime();
		$now->setTime(0, 0, 0);
		$result = $query
			->where('date', '>=', MongoUtils::convertDatePhpToMongo($now))
			->limit(($notification && $notification->accumulated_dou_send ? $limit-$notification->accumulated_dou_send : $limit))
			->get();
		foreach ($result as &$value){
			$categories         = $value->categories;
			$value->organ       = $categories[0]['name'];
			$value->subOrgans   = '';
			for ($i=1;$i<count($categories);$i++){
				$value->subOrgans.=($i>1? ' / ': '').$categories[$i]['name'];
			}
			
		}
		return $result;
		
	}
	
}
