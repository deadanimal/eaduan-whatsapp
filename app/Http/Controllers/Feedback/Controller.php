<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Feedback\FeedTemplate;
use Illuminate\Http\Request;
use App\UserAccess;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * get DT data for new whatsapp feedback
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
		$user = $request->user()->id;
		$role = UserAccess::where('user_id', $user)->first()->role_code;
		$jenis_user = $role;
        return view('feedback.index',[
			'jenis_user' => $jenis_user
		]);
    }


}
