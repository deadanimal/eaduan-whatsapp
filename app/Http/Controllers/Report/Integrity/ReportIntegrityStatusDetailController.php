<?php

namespace App\Http\Controllers\Report\Integrity;

use App\Http\Controllers\Controller;
use App\Integriti\IntegritiAdmin;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;

/**
 * Laporan Integriti - Statistik Aduan Mengikut Status ( Maklumat Terperinci )
 */
class ReportIntegrityStatusDetailController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $data['appname'] = config('app.name', 'eAduan 2.0');
        $data['title'] = 'Laporan Integriti - Statistik Aduan Mengikut Status ( Maklumat Terperinci )';
        $data['currentdatetime'] = Carbon::now()->format('YmdHis');
        $data['filename'] = ($data['appname'] ?? '') . ' ' . ($data['title'] ?? '') . ' '
            . ($data['currentdatetime'] ?? '');

        $data['issearch'] = count($input) > 0 ? true : false;

        if ($data['issearch']) {
            $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
            $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
            $data['datetext'] = 'Tarikh (Terima) : Dari ' . ($data['datestart'] ?? '') . ' Hingga '
                . ($data['dateend'] ?? '');

            $data['status'] = $input['status'] ?? null;
            $data['statusdescription'] = RefRepository::getDescr('1334', ($data['status'] ?? ''), 'ms');
            $data['statustext'] = 'Status Aduan : ' . ($data['statusdescription'] ?? '');

            $data['url'] = $request->fullUrl();
            $data['urlseparator'] = !str_contains($data['url'], '?') ? '?' : '&';
            $data['urlexcel'] = ($data['url'] ?? '') . ($data['urlseparator'] ?? '') . 'generate=excel';

            $data['generate'] = $input['generate'] ?? null;

            $data['integritycomplaints'] = self::query($input);

            switch ($data['generate']) {
                case 'excel':
                    return Excel::create($data['filename'] ?? $data['generate'], function ($excel) use ($request, $data) {
                        $excel->sheet('Laporan', function ($sheet) use ($request, $data) {
                            $sheet->loadView('report.integrity.statusdetail.excel')
                                ->with(['request' => $request, 'data' => $data]);
                        });
                    })->export('xlsx');
                    break;
                default:
                    return view('report.integrity.statusdetail.index', compact('request', 'data'));
                    break;
            }
        }
        return view('report.integrity.statusdetail.index', compact('request', 'data'));
    }

    /**
     * query for get data
     *
     * @param array $input
     * @return mixed
     */
    public function query(array $input)
    {
        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
        $data['datetimestart'] = Carbon::createFromFormat('d-m-Y', $data['datestart'])
            ->startOfDay()->toDateTimeString();
        $data['datetimeend'] = Carbon::createFromFormat('d-m-Y', $data['dateend'])
            ->endOfDay()->toDateTimeString();

        $data['status'] = $input['status'] ?? null;

        $integrityComplaints = IntegritiAdmin::select(
                'integriti_case_info.id','integriti_case_info.IN_STATUSPENGADU',
                'integriti_case_info.IN_NATCD','integriti_case_info.IN_COUNTRYCD',
                'integriti_case_info.IN_RCVTYP','integriti_case_info.IN_CMPLCAT',
                'integriti_case_info.IN_SEXCD','integriti_case_info.IN_INVBY',
                'integriti_case_info.IN_INVDT','integriti_case_info.IN_CASEID',
                'integriti_case_info.IN_SUMMARY','integriti_case_info.IN_NAME',
                'integriti_case_info.IN_INVSTS','integriti_case_info.IN_RCVDT',
                'integriti_case_info.IN_COMPLETEDT','integriti_case_info.IN_AGAINSTNM',
                'integriti_case_info.IN_CLOSEDT','integriti_case_info.IN_CMPLCD',
                'integriti_case_info.IN_SUMMARY_TITLE','integriti_case_info.IN_EMAIL'
            )
            ->where([
                ['IN_CASEID', '<>', null],
                ['IN_CASEID', '<>', ''],
                ['IN_INVSTS', '!=', '010']
            ]);

        if(isset($data['status'])) {
            $integrityComplaints->where('IN_INVSTS', $data['status']);
        }

        $integrityComplaints->whereBetween('IN_RCVDT', [
            $data['datetimestart'],
            $data['datetimeend']
        ]);

        $integrityComplaints = $integrityComplaints->get();

        return $integrityComplaints;
    }
}
