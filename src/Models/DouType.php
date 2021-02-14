<?php

namespace Oka6\DouApi\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Oka6\Admin\Helper\Helper;
use Oka6\Admin\Models\Sequence;

class DouType extends Model {
	const TABLE = 'dou_type';
	protected $fillable = [
		'id',
		'name',
		'slug'
	];
	protected $table = 'dou_type';
	protected $connection = 'oka6_douapi';
	public static function getToSaveFilter($ids){
		if(!count($ids)) return [];
		$data  = self::getByArrayIds($ids);
		$array= [];
		foreach ($data as $value){
			$array[] = ['id'=>$value->id,'name'=>$value->name];
		}
		return $array;
	}
	public static function getByArrayIds($ids){
		$idsMap = array_map(function($id) {
			return (int)$id;
		}, $ids);
		return self::whereIn('id', $idsMap)->get();
	}
	public static function createOrUpdate($name) {
		$slug = Helper::slugify($name);
		$douType = self::getBySlugWithCache($slug);
		if (!$douType){
			$douType = self::create([
				'id'=> Sequence::getSequence(self::TABLE),
				'name'=> $name,
				'slug'=> $slug,
			]);
		}
		return $douType;
	}
	
	public static function getBySlugWithCache($slug) {
		return Cache::tags(['sulradio'])->remember('dou-type-'.$slug, 120, function () use($slug){
			return self::where('slug', $slug)->first();
		});
	}
	
	public static function searchCategory($text) {
		$slug = Helper::slugify($text);
		return self::where('slug','like', '%'.$slug.'%')->limit(10)->get();
	}
	
}
