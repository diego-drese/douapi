<?php

namespace Oka6\DouApi\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Oka6\Admin\Http\Library\ResourceAdmin;
use Oka6\DouApi\Models\Dou;
use Oka6\DouApi\Models\DouCategory;
use Oka6\DouApi\Models\DouType;
use Yajra\DataTables\DataTables;

class DouController extends DouApiController  {
	use ValidatesRequests;
	
	public function index(Request $request) {
		$lastProcessed      =  Dou::getLastProcessed();
		if ($request->ajax()) {
			
			$searchCategory = $request->get('search_category');
			if($searchCategory){
				$search = DouCategory::searchCategory($searchCategory);
				return response()->json($search);
			}
			$searchType     = $request->get('search_type');
			if($searchType){
				$search = DouType::searchCategory($searchType);
				return response()->json($search);
			}
			
			$id     = $request->get('id');
			if($id){
				$search = Dou::getById($id);
				return response()->json($search);
			}
			
			$query          = Dou::query();
			$order          = $request->get('my_order');
			$direction      = $request->get('direction');
			$period         = $request->get('period');
			if($period){
				$query->withPeriod($period);
			}
			$categories     = $request->get('categories');
			if($categories){
				$query->withCategories($categories);
			}
			$types          = $request->get('types');
			if($types){
				$query->withTypes($types);
			}
			$subject        = $request->get('subject');
			if($subject){
				$query->withSubject($subject);
			}
			$pub            = $request->get('pub');
			if($pub){
				$query->withPub($pub);
			}
			if($order && $direction){
				$query->orderBy($order, $direction);
			}else{
				$query->orderBy('date', 'desc');
			}
		
			return DataTables::of($query)->toJson(true);
			/** Busca os artigos */
		}
		return $this->renderView('DouApi::backend.dou.index', ['lastProcessed'=>$lastProcessed]);
	}
	
	protected function makeParameters($extraParameter = null) {
		$parameters = [
			'hasAddAto' => ResourceAdmin::hasResourceByRouteName('plan.store'),
			'hasEditAto' => ResourceAdmin::hasResourceByRouteName('plan.store'),
		];
		$this->parameters = $parameters;
	}
	
	
}