<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\KpdnMyIdentityRepository;
use Illuminate\Http\Request;

/**
 * Fetch data of person using malaysia identification number.
 *
 * Class MyIdentityController
 * @package App\Http\Controllers\Api
 */
class MyIdentityController extends Controller
{
    /**
     * Fetch data of person using malaysia identification number.
     * GET /api/myidentity/{ic}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ic
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $ic)
    {
        $method = $request->method();

        if (!$request->isMethod('post')) {
            return response()->json(['error' => ['message' => 'Request Method is not valid']]);
        }

        $type = 'all';

        $data = KpdnMyIdentityRepository::search($ic, $type);

        if ($data) {
            return response()->json($data);
        }

        return response()->json();
    }
}
