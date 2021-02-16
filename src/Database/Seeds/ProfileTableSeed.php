<?php


namespace Oka6\DouApi\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Oka6\Admin\Models\Profile;
use Oka6\Admin\Models\Resource;
use Oka6\DouApi\Models\Dou;

class ProfileTableSeed extends Seeder {
	
	public function run() {
		Profile::where('id', Dou::DOU_PROFILE_ID)->delete();
		$resources      = Resource::where('route_name', 'LIKE', 'douapi.%')->get();
		$resourcesArray = $resources->pluck('id')->toArray();
		$idsMap = array_map(function($id) {
			return (int)$id;
		}, $resourcesArray);
		
		Profile::insert(
			[
				'id' => Dou::DOU_PROFILE_ID,
				'type' => Config::get('douapi.profile_type')['dou'],
				'name' => "DouApi",
				'desc' => "Perfil para usuários douAPI",
				'resources_allow' => $idsMap,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]
		);
		
	}
}
