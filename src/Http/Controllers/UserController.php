<?php

namespace Oka6\Admin\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Image;

use Oka6\Admin\Http\Library\ResourceAdmin;
use Oka6\Admin\Models\Profile;
use Oka6\Admin\Models\Resource;
use Oka6\Admin\Models\Sequence;
use Oka6\Admin\Models\User;

use Yajra\Datatables\Datatables;


class UserController extends BaseController {
	use ValidatesRequests;
	
	public function index(Request $request, DataTables $datatables) {
		if ($request->ajax()) {
			$query = User::all();
			
			return Datatables::of($query)
				->addColumn('edit_url', function ($row) {
					if (isset($row->id)) {
						return route('admin.users.edit', [$row->id]);
					} else {
						return '';
					}
				})
				->addColumn('profileName', function ($row) {
					$profile = Profile::where('id', (int)$row->profile_id)->first();
					if ($profile) {
						return $profile->name;
					} else {
						return '';
					}
					
				})
				->addColumn('resourceName', function ($row) {
					$resource = Resource::where('id', (int)$row->resource_default_id)->first();
					return isset($resource->name) ? $resource->name : '';
				})
				->setRowClass(function () {
					return 'center';
				})
				->make(true);
		}
		
		$hasAdd = ResourceAdmin::hasResourceByRouteName('admin.users.create');
		$hasEdit = ResourceAdmin::hasResourceByRouteName('admin.users.edit', [1]);
		return view('Admin::backend.users.index', compact('hasAdd', 'hasEdit'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(User $user) {
		$profiles = Profile::all('id', 'name');
		$clients = [];
		$hasSave = ResourceAdmin::hasResourceByRouteName('admin.users.store');
		return view('Admin::backend.users.create', compact('profiles', 'user', 'clients', 'hasSave'));
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
			'profile_id' => 'required|integer',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6|',
			'email' => ['required', function ($attribute, $value, $fail) {
				$result = User::where('email', $value)->first();
				if ($result) {
					$fail($attribute . ' Email inválido.');
				}
			},]
		
		], ['required' => 'Campo obrigatório', 'unique' => 'Email já cadastrado']);
		
		$dataForm['id'] = Sequence::getSequence('users');
		$dataForm['name'] = $request->get('name');
		$dataForm['lastname'] = $request->get('lastname');
		$dataForm['email'] = $request->get('email');
		$dataForm['cell_phone'] = $request->get('cell_phone');
		$dataForm['profile_id'] = $request->get('profile_id');
		$dataForm['resource_default_id'] = $request->get('resource_default_id');
		$dataForm['client_id'] = $request->get('client_id');
		$dataForm['active'] = $request->get('active') ? 1 : 0;
		$dataForm['password'] = bcrypt($request->get('password_confirmation'));
		$dataForm['type'] = 'root';
		$request->user()->create($dataForm);
		toastr()->success('Usuário Criado!', 'Sucesso');
		return redirect(route('admin.users.index'));
		
	}
	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id) {
		$user = User::where('id', (int)$id)->first();
		$profiles = Profile::select('id', 'name')->get();
		$clients = [];
		$profileCurrent = "";
		$clientCurrent = [];
		foreach ($profiles as $profile) {
			if ($profile->id == $user->profile_id) {
				$profileCurrent = $profile->name;
			}
		}
		foreach ($clients as $client) {
			if ($client->id == $user->client_id) {
				$clientCurrent = $client->name;
			}
		}
		$hasSave = ResourceAdmin::hasResourceByRouteName('admin.users.update', [1]);
		return view('Admin::backend.users.edit', compact('user', 'clients', 'profiles', 'hasSave', 'profileCurrent', 'clientCurrent'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request, $id) {
		$user = User::firstOrNew(['id' => (int)$id]);
		$this->validate($request, [
			'name' => 'required',
			'profile_id' => 'required|integer',
			'password' => 'nullable|min:6|confirmed|nullable',
			'password_confirmation' => 'nullable|min:6',
			'email' => ['required', function ($attribute, $value, $fail) use ($id) {
				$result = User::where('email', $value)->where('id', '!=', (int)$id)->first();
				if ($result) {
					$fail($attribute . ' Email inválido.');
				}
			},]
		
		], ['required' => 'Campo obrigatório', 'unique' => 'Email já cadastrado']);
		$dataForm = [];
		$dataForm['name'] = $request->get('name');
		$dataForm['lastname'] = $request->get('lastname');
		$dataForm['email'] = $request->get('email');
		$dataForm['cell_phone'] = $request->get('cell_phone');
		$dataForm['profile_id'] = $request->get('profile_id');
		$dataForm['resource_default_id'] = $request->get('resource_default_id');
		$dataForm['client_id'] = $request->get('client_id');
		$dataForm['active'] = $request->get('active') ? 1 : 0;
		if ($request->get('password_confirmation')) {
			$dataForm['password'] = bcrypt($request->get('password_confirmation'));
		}
		
		$user->update($dataForm);
		toastr()->success('Usuário Atualizado com sucesso', 'Sucesso');
		return redirect(route('admin.users.index'));
	}
	
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function viewUserProfile() {
		
		$auth = Auth::user();
		$user = User::firstOrNew(['id' => (int)$auth->id]);
		$profiles = Profile::pluck('name', 'id')->toArray();
		return view('Admin::backend.users.edit-profile', compact('profiles', 'user'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function updateUserProfile(Request $request) {
		$dataForm = [];
		$auth = Auth::user();
		$user = User::firstOrNew(['id' => (int)$auth->id]);
		
		$this->validate($request, [
			'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'name' => 'required',
			'resource_default_id' => 'required',
			'email' => 'required',
			'old_password' => [function ($attribute, $value, $fail) use ($request, $user) {
				if (!Hash::check($request->old_password, $user->password)) {
					$fail('Current Password dont match!');
				}
				if ($value == '') {
					$fail('Current Password is required!');
				}
				
			}],
			'password' => ['confirmed'],
		]);
		
		$dataForm['password'] = bcrypt($request->get('password'));
		if ($request->hasFile('picture')) {
			$image = $request->file('picture');
			$input['picture'] = time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = storage_path('/app/public/thumbnail');
			
			if (!File::isDirectory($destinationPath)) {
				File::makeDirectory($destinationPath, 0777);
			}
			$img = Image::make($image->getRealPath());
			$img->resize(100, 100, function ($constraint) {
				
				$constraint->aspectRatio();
				
			})->save($destinationPath . '/' . $input['picture']);
			
			$base64 = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode($img);
			$dataForm['picture'] = $base64;
		}
		
		if (!isset($request->password)) {
			unset($dataForm['password']);
		}
		
		$dataForm['name'] = $request->get('name');
		$dataForm['lastname'] = $request->get('lastname');
		$dataForm['email'] = $request->get('email');
		$dataForm['cell_phone'] = $request->get('cell_phone');
		$dataForm['resource_default_id'] = $request->get('resource_default_id');
		$user->fill($dataForm)->save();
		toastr()->success('Usuário Atualizado com sucesso', 'Sucesso');
		return redirect(route('admin.users.form-profile'));
	}
	
	
}
