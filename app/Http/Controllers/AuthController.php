<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {

	public function login(Request $request) {

		$credentials = $request->only('email', 'password');

		if (!$token = JWTAuth::attempt($credentials)) {
			return response([
				'status' => 'error',
				'error' => 'invalid.credentials',
				'msg' => 'Credenciales invalidas.',
			], 400);
		}
		return response([
			'status' => 'success',
		])
			->header('Authorization', $token);
	}

	public function register(UserStoreRequest $request) {
		$user = new User;
		$user->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $user,
		], 200);
	}

	public function update(UserStoreRequest $request, User $user) {
		$user->update(['name' => $request->name, 'email' => $request->email]);
		return response([
			'status' => 'success',
			'data' => $user,
		], 200);
	}

	public function delete(User $user) {
		$user->delete();
		return response([
			'status' => 'success',
			'data' => $user,
		], 200);
	}

	public function user(Request $request) {
		$user = User::find(Auth::user()->id);
		return response([
			'status' => 'success',
			'data' => $user,
		]);
	}

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$extractions = User::where('name','LIKE',$filter)
			->orWhere('email','LIKE',$filter)
			->orWhere('rol','LIKE',$filter)
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($extractions->total()/$perPage),
	            'currentPage'	=> $extractions->currentPage(),
	        ],
	        'data' => $extractions->all()
    	], 200);
	}

	public function index() {
		$users = User::all();

		return response([
			'status' => 'success',
			'data' => $users,
		]);

	}
	public function refresh() {
		return response([
			'status' => 'success',
		]);

		// return $this->respondWithToken(auth()->refresh());

	}

	public function logout() {
		JWTAuth::invalidate();
		return response([
			'status' => 'success',
			'msg' => 'Logged out Successfully.',
		], 200);
	}

	protected function respondWithToken($token) {
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60,
		]);
	}
}
