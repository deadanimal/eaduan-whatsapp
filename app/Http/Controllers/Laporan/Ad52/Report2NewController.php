<?php

namespace App\Http\Controllers\Laporan\Ad52;

use App\Aduan\Carian;
use App\Http\Controllers\Controller;
use App\Libraries\DateTimeLibrary;
use App\Models\Cases\CaseInfo;
use App\Ref;
use App\Repositories\Ad52Repository;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;
use View;

/**
 * AD52 Penyelesaian
 *
 * Laporan Analisa Data
 */
class Report2NewController extends Controller
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

        $data['issearch'] = count($input) > 0 ? true : false;

        $data['title'] = 'AD52 Laporan Analisa Data';

        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
        // $date_start = isset($input['date_start'])
        //     ? Carbon::parse($input['date_start'])->startOfDay()->toDateTimeString()
        //     : Carbon::now()->startOfDay()->toDateTimeString();
        // $date_end = isset($input['date_end'])
        //     ? Carbon::parse($input['date_end'])->endOfDay()->toDateTimeString()
        //     : Carbon::now()->endOfDay()->toDateTimeString();

        $data['states'] = RefRepository::getList($cat = '17', $sort = 'sort', $lang = 'ms');
        $data['state'] = $input['state'] ?? null;

        $data['generate'] = $input['generate'] ?? null;

        $actTemplates = Ref::where(['cat' => '713', 'status' => '1'])
            ->orderBy('sort', 'asc')->pluck('descr', 'code')->toArray();
        $countActTemplate = count($actTemplates);
        foreach ($actTemplates as $key => $value) {
            $dataTemplates[$key] = 0;
        }
        $dataTemplateRows = ['achieveObjective', 'notAchieveObjective',
            'totalComplaintTakenAction', 'inProgress', 'total',
            'average', 'mode', 'median', 'min', 'max'
        ];
        foreach ($dataTemplateRows as $value) {
            $dataCount[$value] = $dataTemplates;
        }

        if ($data['issearch']) {
            $data['appname'] = config('app.name', 'eAduan 2.0');
            $data['filename'] = $data['appname'] . ' ' . $data['title'] . date(" YmdHis");

            $data['datestartvalidate'] = DateTimeLibrary::validate($data['datestart']);
            $data['dateendvalidate'] = DateTimeLibrary::validate($data['dateend']);

            $data['datestartvalid'] = Carbon::parse($data['datestartvalidate']);
            $data['dateendvalid'] = Carbon::parse($data['dateendvalidate']);

            $data['datestartstring'] = $data['datestartvalid']->format('d-m-Y');
            $data['dateendstring'] = $data['dateendvalid']->format('d-m-Y');

            $data['datetimestart'] = $data['datestartvalid']->startOfDay()->toDateTimeString();
            $data['datetimeend'] = $data['dateendvalid']->endOfDay()->toDateTimeString();

            $data['datetext'] = 'Tarikh Penerimaan : Dari ' . ($data['datestartstring'] ?? '') 
                . ' Hingga ' . ($data['dateendstring'] ?? '');

            $data['statedescription'] = RefRepository::getDescr('17', ($data['state'] ?? ''), 'ms');
            $data['statetext'] = 'Negeri : ' . ($data['statedescription'] ?? '');
            $data['statefilter'] = $data['states']->has($data['state']);

            $data['caseinfos'] = self::query($data);
            foreach ($data['caseinfos'] as $key => $caseinfo) {
                $caseact = Ad52Repository::getCaseAct($caseinfo->CA_CASEID ?? '');
                $caseinfo->act = $caseact ?? '';
                $casedetail = Ad52Repository::getCaseDetailAnswer($caseinfo->CA_CASEID ?? '');
                $caseinfo->reasonduration = $casedetail->CD_REASON_DURATION ?? 0;
                foreach ($actTemplates as $keyActTemplate => $actTemplate) {
                    if ($keyActTemplate === $caseinfo->act) {
                        switch (true) {
                            case $caseinfo->reasonduration <= 21:
                                $dataCount['achieveObjective'][$keyActTemplate]++;
                                break;
                            case $caseinfo->reasonduration > 21:
                                $dataCount['notAchieveObjective'][$keyActTemplate]++;
                                break;
                            default:
                                break;
                        }
                        $dataCount['totalComplaintTakenAction'][$keyActTemplate]++;
                        $dataCount['total'][$keyActTemplate]++;
                        break;
                    }
                }
            }

            foreach ($actTemplates as $keyActTemplate => $actTemplate) {
                $filtered = $data['caseinfos']->where('act', $keyActTemplate);
                if ($filtered->isNotEmpty()) {
                    $dataCount['average'][$keyActTemplate] = number_format($filtered->avg('reasonduration'));
                    $dataCount['mode'][$keyActTemplate] = $filtered->mode('reasonduration');
                    $dataCount['median'][$keyActTemplate] = number_format($filtered->median('reasonduration'));
                    $dataCount['min'][$keyActTemplate] = $filtered->min('reasonduration');
                    $dataCount['max'][$keyActTemplate] = $filtered->max('reasonduration');
                }
            }

            $data['urldetail'] = '/report/ad52/report2detail' . '?' . explode('?', url()->full())[1] ?? '';
        }

        switch ($data['generate']) {
            // case 'xls':
            //     return view('laporan.ad52.report2new.excelxls',
            //         compact('request', 'title', 'date_start', 'date_end', 'gen', 'dataCount', 'dataTemplates', 'actTemplates', 'countActTemplate', 'fileName', 'appName', 'data')
            //     );
            //     break;
            case 'excel':
                if (View::exists('laporan.ad52.report2new.excel')) {
                    return Excel::create($data['filename'] ?? $data['generate'], function ($excel) use ($request, $data, $countActTemplate, $actTemplates, $dataTemplates, $dataCount) {
                        $excel->sheet('Laporan', function ($sheet) use ($request, $data, $countActTemplate, $actTemplates, $dataTemplates, $dataCount) {
                            $sheet->loadView('laporan.ad52.report2new.excel')
                                ->with([
                                    'request' => $request,
                                    'data' => $data,
                                    'countActTemplate' => $countActTemplate,
                                    'actTemplates' => $actTemplates,
                                    'dataTemplates' => $dataTemplates,
                                    'dataCount' => $dataCount
                                ]);
                        });
                    })->export('xlsx');
                } else {
                    abort(404);
                }
                break;
            case 'pdf':
                $pdf = PDF::loadView('laporan.ad52.report2new.pdf',
                    compact('request', 'title', 'date_start', 'date_end', 'gen', 'dataCount', 'dataTemplates', 'actTemplates', 'countActTemplate', 'fileName', 'appName', 'data')
                );
                return $pdf->download($data['filename'] . '.pdf');
                break;
            case 'web':
            default:
                return view('laporan.ad52.report2new.index',
                    compact('request', 'isSearch', 'title', 'date_start', 'date_end', 'gen', 'dataCount', 'dataTemplates', 'actTemplates', 'countActTemplate', 'fileName', 'appName', 'data')
                );
                break;
        }
        // return view('laporan.ad52.report2new.index',
        //     compact('request', 'isSearch', 'title', 'date_start', 'date_end', 'gen', 'dataCount', 'dataTemplates', 'actTemplates', 'countActTemplate', 'fileName', 'appName', 'data')
        // );
    }

    /**
     * query for get data
     *
     * @param array $data
     */
    public function query($data)
    {
        $query = Carian::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->join('sys_ref', 'sys_brn.BR_STATECD', '=', 'sys_ref.code')
            ->select(DB::raw("
                case_info.CA_CASEID,
                case_info.CA_FILEREF,
                case_info.CA_DEPTCD,
                case_info.CA_RCVDT,
                case_info.CA_FA_DURATION,
                sys_brn.BR_STATECD,
                sys_ref.descr,
                case_info.CA_MAGNCD,
                case_info.CA_COMPLETEDT,
                case_info.CA_SSP
            "))
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10'],
                ['sys_ref.cat', '=', '17']
            ])
            ->whereNotNull('case_info.CA_RCVDT');
            if(!empty($data['state'])) {
                $query = $query->where('sys_brn.BR_STATECD', $data['state']);
            }
            $query = $query->get();
        return $query;
    }
}
