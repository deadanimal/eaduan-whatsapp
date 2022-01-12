<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicCaseRating\StoreCaseRatingRequest;
use App\Models\Cases\CaseInfo;
use App\Models\Cases\CaseRating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Public User Consumer Complaint Rating.
 *
 * Class PublicCaseRatingController
 * @package App\Http\Controllers\Aduan
 */
class PublicCaseRatingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->only('casenumber');

        $user = auth()->user();

        $data['casenumber'] = $input['casenumber'] ?? null;

        $data['caseInfo'] = CaseInfo::where('CA_CASEID', $data['casenumber'])->first();

        $data['answer1'] = old('answer1');
        $data['answer2'] = old('answer2');
        $data['answer3'] = old('answer3');
        $data['answer4'] = old('answer4');

        $data['answer_date'] = Carbon::today()->format('d-m-Y');

        if (!empty($data['caseInfo']) && View::exists('aduan.public.rating.create')) {
            return view('aduan.public.rating.create', compact('input', 'user', 'data'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCaseRatingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaseRatingRequest $request)
    {
        $user = auth()->user();

        $input = $request->all();

        $input['name'] = $user['name'] ?? null;
        $input['ic_number'] = $user['icnew'] ?? null;
        $input['telephone_number'] = $user['mobile_no'] ?? null;
        $input['email'] = $user['email'] ?? null;

        /** @var CaseRating $caseRating */
        $caseRating = CaseRating::create($input);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Maklum Balas Anda telah berjaya disimpan.');
    }
}
