<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\KpdnMyIdentityRepository;
use App\Repositories\MyIdentityDataRepository;
use App\Repositories\MyIdentityRepository;
use Illuminate\Http\Request;

/**
 * Fetch data of person using malaysia identification number.
 *
 * Class MyIdentityController
 * @package App\Http\Controllers\Admin
 */
class MyIdentityController extends Controller
{
    /**
     * MyIdentityController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch data of person using malaysia identification number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ic
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $ic = null)
    {
        if ($ic == null) {
            return json_encode('');
        }

        $RequestDateTime = date('Y-m-d H:i:s'); //date("Y-m-d") . "T" . date("H:i:s");

        // $method = $request->method();

        // if (!$request->isMethod('post')) {
        //     return response()->json(['error' => ['message' => 'Request Method is not valid']]);
        // }

        $type = 'all';

        $userId = auth()->user()->username ?? $ic;

        // $data = KpdnMyIdentityRepository::search($ic, $type);
        $data = KpdnMyIdentityRepository::search($ic, $userId, $type);

        $dataManipulate = MyIdentityDataRepository::grabData($data);
        $dataManipulate['RequestDateTime'] = $RequestDateTime;

        MyIdentityRepository::generatelog($dataManipulate);

        if ($dataManipulate) {
            return response()->json($dataManipulate);
        }

        return response()->json();
    }
}
