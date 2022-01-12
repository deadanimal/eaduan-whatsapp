<?php

namespace App\Http\Controllers\Report\AskEnquiry;

use App\Http\Controllers\Controller;
use App\Pertanyaan\PertanyaanAdmin;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;

/**
 * Laporan Pertanyaan / Cadangan - Kategori.
 *
 * Class ReportAskEnquiryCategoryController
 * @package App\Http\Controllers\Report\AskEnquiry
 */
class ReportAskEnquiryCategoryController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $data['isSearch'] = count($input) > 0 ? true : false;
        $data['title'] = 'Laporan Pertanyaan / Cadangan - Kategori';

        for ($i = 2018; $i <= date('Y'); $i++) {
            $data['yearList'][$i] = $i;
        }

        $data['year'] = $input['year'] ?? date('Y');
        $data['generate'] = $input['generate'] ?? null;

        $data['refConsumerComplaintCategories'] = RefRepository::getList($cat = '244')->toArray();
        $data['refAskEnquiryCategories'] = RefRepository::getList($cat = '1277')->toArray();
        $data['refCategories'] = array_merge($data['refConsumerComplaintCategories'], $data['refAskEnquiryCategories']);

        if ($data['isSearch']) {
            $data['appname'] = config('app.name', 'eAduan 2.0');
            $data['currentdatetime'] = Carbon::now()->format('YmdHis');
            $data['filename'] = ($data['appname'] ?? '') . ' ' . ($data['title'] ?? '') . ' '
                . ($data['currentdatetime'] ?? '');

            $data['yeartext'] = 'Tahun : ' . ($data['year'] ?? '');

            $data['url'] = $request->fullUrl();
            $data['urlseparator'] = !str_contains($data['url'], '?') ? '?' : '&';
            $data['urlexcel'] = ($data['url'] ?? '') . ($data['urlseparator'] ?? '') . 'generate=excel';
            $data['urlpdf'] = ($data['url'] ?? '') . ($data['urlseparator'] ?? '') . 'generate=pdf';

            $data['headings'] = ['Bil.', 'Kategori', 'Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis', 'Jumlah'];

            $data['askInfos'] = self::query($input);

            for ($i = 1; $i <= 12; $i++) {
                $data['template'][$i] = 0;
            }
            $data['template']['total'] = 0;

            foreach($data['refCategories'] as $key => $row){
                $data['count'][$key] = $data['template'];
            }
            $data['count']['total'] = $data['template'];

            foreach($data['askInfos'] as $keyAskInfo => $rowAskInfo){
                foreach($data['refCategories'] as $keyRefCategory => $rowRefCategory){
                    foreach($data['template'] as $keytemplate => $rowtemplate){
                        if(($rowAskInfo->AS_CMPLCAT == $keyRefCategory) && ($rowAskInfo->month == $keytemplate)){
                            $data['count'][$keyRefCategory][$keytemplate] += $rowAskInfo->total;
                            $data['count'][$keyRefCategory]['total'] += $rowAskInfo->total;
                            $data['count']['total'][$keytemplate] += $rowAskInfo->total;
                            $data['count']['total']['total'] += $rowAskInfo->total;
                        }
                    }
                }
            }
        }

        switch ($data['generate']) {
            case 'excel':
                if (View::exists('report.askenquiry.category.excel')) {
                    return Excel::create($data['filename'] ?? $data['generate'], function ($excel) use ($request, $data) {
                        $excel->sheet('Laporan', function ($sheet) use ($request, $data) {
                            $sheet->loadView('report.askenquiry.category.excel')
                                ->with(['request' => $request, 'data' => $data]);
                        });
                    })->export('xlsx');
                } else {
                    abort(404);
                }
                break;
            case 'pdf':
                if (View::exists('report.askenquiry.category.pdf')) {
                    return PDF::loadView('report.askenquiry.category.pdf', compact('request', 'data'))
                        ->download(($data['filename'] ?? $data['generate']). '.' . $data['generate']);
                } else {
                    abort(404);
                }
                break;
            default:
                if (View::exists('report.askenquiry.category.index')) {
                    return view('report.askenquiry.category.index', compact('request', 'input', 'data'));
                } else {
                    abort(404);
                }
                break;
        }
    }

    /**
     * Query to get data.
     *
     * @param  array  $input
     * @return PertanyaanAdmin[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query($input)
    {
        $data['year'] = $input['year'] ?? date('Y');
        $data['yearCarbon'] = Carbon::createFromFormat('Y', $data['year']);

        return PertanyaanAdmin::select(
            DB::raw('count(ask_info.id) as total'),
            DB::raw('month(ask_info.AS_RCVDT) as month'),
            'ask_info.AS_CMPLCAT')
            ->where('ask_info.AS_ASKSTS', 3)
            ->whereNotNull('ask_info.AS_CMPLCAT')
            ->whereBetween('ask_info.AS_RCVDT', [
                $data['yearCarbon']->startOfYear()->toDateTimeString(),
                $data['yearCarbon']->endOfYear()->toDateTimeString()
            ])
            ->groupBy('ask_info.AS_CMPLCAT', DB::raw('month(ask_info.AS_RCVDT)'))
            ->get();
    }
}
