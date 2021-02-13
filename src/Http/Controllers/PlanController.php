<?php

namespace Oka6\DouApi\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Oka6\Admin\Http\Library\ResourceAdmin;
use Oka6\DouApi\Models\Plan;
use Yajra\DataTables\DataTables;

class PlanController extends DouApiController  {
	use ValidatesRequests;
	
	public function index(Request $request) {
		if ($request->ajax()) {
			$query = Plan::query();
			return DataTables::of($query)->toJson(true);
		}
		return $this->renderView('DouApi::backend.plan.index');
	}
	
	public function create(Plan $data) {
		return $this->renderView('DouApi::backend.plan.create', ['data' => $data]);
	}

	protected function makeParameters($extraParameter = null) {
		$parameters = [
			'hasAddPlan' => ResourceAdmin::hasResourceByRouteName('douapi.plan.add'),
			'hasStorePlan' => ResourceAdmin::hasResourceByRouteName('douapi.plan.store'),
			'hasEditPlan' => ResourceAdmin::hasResourceByRouteName('douapi.plan.edit', [1]),
			'hasUpdatePlan' => ResourceAdmin::hasResourceByRouteName('douapi.plan.update', [1]),
		];
		$this->parameters = $parameters;
	}
	
	
}