<?php


namespace Oka6\DouApi\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Oka6\Admin\Models\Profile;
use Oka6\Admin\Models\Resource;
use Oka6\Admin\Models\Sequence;
use Oka6\Admin\Models\User;

class ResourceTableSeed extends Seeder {
	
	public function run() {
		if (!Resource::getResourceIdByRouteName('Configuration')) {
			$profile = Profile::where('id', User::PROFILE_ID_ROOT)->first();
			$id = Sequence::getSequence('resource');
			Resource::insert([
				[
					'id' => $id,
					'name' => "Configurações",
					'menu' => 'Configurações',
					'is_menu' => 1,
					'route_name' => 'Configuration',
					'icon' => 'fas fa-cogs',
					'controller_method' => '',
					'can_be_default' => 0,
					'parent_id' => 0,
					'order' => 1,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				]
			]);
			if (!count($profile->resources_allow)) {
				$profile->resources_allow = [$id];
				
			} else {
				$profile->resources_allow = array_merge($profile->resources_allow, [$id]);
				
			}
			
			$profile->save();
		}
	}
}
