<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cases\CaseReasonTemplate;
use Illuminate\Http\Request;

/**
 * Class CaseReasonTemplateController
 * @package App\Http\Controllers\Api
 */
class CaseReasonTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/casereasontemplates
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CaseReasonTemplate::select('id', 'category', 'code', 'descr', 'sort', 'status')->get();

        return response()->json(['data' => $data->toArray()]);
    }
}
