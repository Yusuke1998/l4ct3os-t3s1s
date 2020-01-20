<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineStoreRequest;
use App\Models\Vaccine\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller {

	public function countTotalToday() {

		$total = Vaccine::today()->count();

		return response([
			'status' => 'success',
			'data' => $total,
		], 200);

	}

	public function index() {

		$vaccines = Vaccine::all();

		return response([
			'status' => 'success',
			'data' => $vaccines,
		], 200);

	}

	public function create() {
		//
	}

	public function register(VaccineStoreRequest $request) {

		dd($request->all());

		$vaccine = new Vaccine();
		$vaccine->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);

	}

	public function show(Vaccine $vaccine) {
		//
	}

	public function edit(Vaccine $vaccine) {
		//
	}

	public function update(VaccineStoreRequest $request, Vaccine $vaccine) {
		$vaccine->update($request->all());

		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);

	}

	public function delete(Vaccine $vaccine) {
		$vaccine->delete();

		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);
	}
}
