<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineStoreRequest;
use App\Models\Vaccine\Vaccine;
use App\Models\Medicine\Medicine;
use Illuminate\Http\Request;

class VaccineController extends Controller {

	public function countTotalToday() {
		$total = Vaccine::today()->count();
		return response([
			'status' => 'success',
			'data' => $total,
		], 200);
	}

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$vaccines = Vaccine::where('quantity','LIKE',$filter)
			->orWhere('date','LIKE',$filter)
			->orWhereHas('employee',function($query) use ($filter){
				return $query
					->where('name','LIKE',$filter)
					->orWhere('identificacion_number','LIKE',$filter);
			})
			->orWhereHas('cow',function($query) use ($filter){
				return $query
					->where('type','LIKE',$filter)
					->orWhere('code','LIKE',$filter);
			})
			->orWhereHas('medicine',function($query) use ($filter){
				return $query
					->where('name_medicine','LIKE',$filter);
			})
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($vaccines->total()/$perPage),
	            'currentPage'	=> $vaccines->currentPage(),
	        ],
	        'data' => $vaccines->all()
    	], 200);
	}

	public function index() {
		$vaccines = Vaccine::all();
		return response([
			'status' => 'success',
			'data' => $vaccines,
		], 200);
	}

	public function register(VaccineStoreRequest $request) {
		$vaccine = new Vaccine();
		$medicine = Medicine::findOrFail($request->medicine_id);
		$quan1 = $medicine->quantity;
		$quan2 = $request->quantity;
		if ($quan1>=$quan2){
			$vaccine->create($request->except('_token'));
			$medicine->quantity-=$request->quantity;
			$medicine->save();
			return response([
				'status' => 'success',
				'data' => $vaccine,
			], 200);
		}else{
			return response([
				'status'	=> 'error',
				'data' 		=> $vaccine,
			], 422);
		}
	}

	public function update(VaccineStoreRequest $request, Vaccine $vaccine){

		if ($vaccine->medicine_id !== $request->medicine_id){
			$medicine = Medicine::findOrFail($request->medicine_id);
			$quan1 = $request->quantity;
			$quan2 = $vaccine->quantity;
			$quan3 = $medicine->quantity;
			if ($quan1 <= $quan3) {
				$oldMedicine = Medicine::findOrFail($vaccine->medicine_id);
				$oldMedicine->quantity += $vaccine->quantity;
				$oldMedicine->save();
				$newMedicine = Medicine::findOrFail($request->medicine_id);
				$quan1 = $newMedicine->quantity;
				$quan2 = $request->quantity;
				if ($quan1>=$quan2){
					$vaccine->update($request->all());
					$newMedicine->quantity -= $request->quantity;
					$newMedicine->save();
					return response([
						'status' => 'success',
						'data' => $vaccine,
					], 200);
				}else{
					return response([
						'status'	=> 'error',
						'data' 		=> $vaccine,
					], 422);
				}
			}else{
				return response([
					'status'	=> 'error',
					'data' 		=> $vaccine,
				], 422);
			}
		}else{
			$medicine = Medicine::findOrFail($request->medicine_id);
			$quan1 = $request->quantity;
			$quan2 = $vaccine->quantity;
			$quan3 = $medicine->quantity;
			if ($quan1 > $quan2 && $quan1 < $quan3){
				$vaccine->update($request->all());
				$medicine->quantity -= ($quan1-$quan2);
				$medicine->save();
				return response([
					'status' => 'success',
					'data' => $vaccine,
				], 200);
			}elseif ($quan1 <= $quan2){
				$vaccine->update($request->all());
				$medicine = Medicine::findOrFail($request->medicine_id);
				$medicine->quantity += ($quan2-$quan1);
				$medicine->save();
				return response([
					'status' => 'success',
					'data' => $vaccine,
				], 200);
			}
		}

		return response([
			'status' => 'error',
			'data' => $vaccine,
		], 422);
	}

	public function delete(Vaccine $vaccine) {
		$vaccine->delete();
		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);
	}
}
