<?php

namespace App\Http\Controllers\Report\Ad52;

use App\Aduan\Carian;
use App\Http\Controllers\Controller;
use App\Libraries\DateTimeLibrary;
use App\Models\Cases\CaseInfo;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DataTables;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;
use View;

/**
 * Aduan Kepenggunaan
 * Laporan AD 52 | Laporan Analisa Data ( Maklumat Terperinci )
 */
class Report2DetailController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $data['issearch'] = count($input) > 0 ? true : false;

        $data['title'] = 'AD52 Laporan Analisa Data ( Maklumat Terperinci )';

        $data['generate'] = $input['generate'] ?? null;

        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');

        $data['state'] = $input['state'] ?? null;

        $data['act'] = $input['act'] ?? null;

        if ($data['issearch']) {
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

            $data['actdescription'] = RefRepository::getDescr('713', ($data['act'] ?? ''), 'ms');
            $data['acttext'] = 'Akta : ' . ($data['actdescription'] ?? '');
        }

        if (View::exists('report.ad52.report2detail.index')) {
            return view('report.ad52.report2detail.index', compact('request', 'data'));
        }
    }

    /**
     * Datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dt(Request $request)
    {
        $input = $request->all();

        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');

        $data['datestartvalidate'] = DateTimeLibrary::validate($data['datestart']);
        $data['dateendvalidate'] = DateTimeLibrary::validate($data['dateend']);

        $data['datestartvalid'] = Carbon::parse($data['datestartvalidate']);
        $data['dateendvalid'] = Carbon::parse($data['dateendvalidate']);

        $data['datestartstring'] = $data['datestartvalid']->format('d-m-Y');
        $data['dateendstring'] = $data['dateendvalid']->format('d-m-Y');

        $data['datetimestart'] = $data['datestartvalid']->startOfDay()->toDateTimeString();
        $data['datetimeend'] = $data['dateendvalid']->endOfDay()->toDateTimeString();

        $data['state'] = $input['state'] ?? null;

        $data['act'] = $input['act'] ?? null;

        $data['caseinfos'] = self::query($data);

        $datatables = DataTables::of($data['caseinfos'])
            ->addIndexColumn()
            ->editColumn('CA_CASEID', function (Carian $penugasan) {
                return view('aduan.tugas.show_summary_link', compact('penugasan'))->render();
            })
            ->editColumn('CA_SUMMARY', function(Carian $Carian) {
                if($Carian->CA_SUMMARY != '')
                    return implode(' ', array_slice(explode(' ', ucfirst($Carian->CA_SUMMARY)), 0, 7)).'...';
                else
                    return '';
            })
            ->editColumn('CA_CMPLCAT', function(Carian $Carian) {
                if(!empty($Carian->CA_CMPLCAT)) {
                    if($Carian->CmplCat) {
                        return $Carian->CmplCat->descr;
                    } else {
                        $Carian->CA_CMPLCAT;
                    }
                } else {
                    return '';
                }
            })
            ->editColumn('CA_RCVDT', function (Carian $Carian) {
                return $Carian->CA_RCVDT ? with(new Carbon($Carian->CA_RCVDT))->format('d-m-Y h:i A') : '';
            })
            ->editColumn('CA_COMPLETEDT', function (Carian $Carian) {
                return $Carian->CA_COMPLETEDT ? with(new Carbon($Carian->CA_COMPLETEDT))->format('d-m-Y h:i A') : '';
            })
            ->editColumn('CA_CLOSEDT', function (Carian $Carian) {
                return $Carian->CA_CLOSEDT ? with(new Carbon($Carian->CA_CLOSEDT))->format('d-m-Y h:i A') : '';
            })
            ->editColumn('CA_INVBY', function(Carian $Carian) {
                if($Carian->CA_INVBY != '')
                    return view('aduan.carian.show_invby_link', compact('Carian'))->render();
                else
                    return '';
            })
            ->rawColumns(['CA_CASEID','CA_INVBY','CA_SUMMARY']);
        return $datatables->make(true);
    }

    /**
     * Query.
     *
     * @return \Illuminate\Http\Response
     */
    public function query($data)
    {
        $query = Carian::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->join('sys_ref', 'sys_brn.BR_STATECD', '=', 'sys_ref.code')
            ->select('case_info.CA_CASEID', 'case_info.CA_SUMMARY',
                'case_info.CA_NAME', 'case_info.CA_AGAINSTNM',
                'sys_brn.BR_BRNNM', 'case_info.CA_CMPLCAT',
                'case_info.CA_RCVDT', 'case_info.CA_COMPLETEDT',
                'case_info.CA_CLOSEDT', 'case_info.CA_INVBY'
            )
            ->whereNotNull('case_info.CA_RCVDT')
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10'],
                ['sys_ref.cat', '=', '17']
            ]);
            if(!empty($data['state'])) {
                $query = $query->where('sys_brn.BR_STATECD', $data['state']);
            }
            if(!empty($data['act'])) {
                $query = $query->join('case_act', function ($join) use ($data) {
                        $join->on('case_info.CA_CASEID', '=', 'case_act.CT_CASEID')
                            ->where('case_act.CT_AKTA', $data['act'])
                            ->limit(1);
                    })
                    // ->where('case_info.CA_SSP', 'YES')
                    ;
            }
            $query = $query->get();
        return $query;
    }
}
