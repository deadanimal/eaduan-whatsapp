<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StateDistrictController extends Controller
{	
	protected function getState() {
		$mState = DB::table('sys_ref')
					->where('cat', '17')
					->where('status', '1')
					->orderBy('sort')
					->get();
					
		return response()->json(['data' => $mState->toArray()]);
	}
	
	protected function getDistrict($state) {
		$mDistrict = DB::table('sys_ref')
					->where('cat', '18')
					->where('status', '1')
					->where('code', 'LIKE', "$state%")
					->orderBy('sort')
					->get();
		
		return response()->json(['data' => $mDistrict->toArray()]);
	}

	public function getByAduanNo($req) {
// dd("masuk");

        $noaduan= $req;
        $mPublicCase = DB::table('case_info')
                ->where(['CA_CASEID' => $noaduan])
                ->first();

        // dd($mPublicCase);
                //dd(gettype($mPublicCase));
        $status = $mPublicCase->CA_INVSTS;



        return response()->json(['data' => $status]);
    }
}
