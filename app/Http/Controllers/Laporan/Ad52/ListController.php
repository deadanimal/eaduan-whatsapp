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
use Illuminate\Http\Request;
use PDF;
use View;
use Yajra\DataTables\Facades\DataTables;

/**
 * AD52 Penyelesaian
 *
 * Senarai Aduan
 */
class ListController extends Controller
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
        $data['title'] = 'AD52 Laporan Fail Aduan';
        // $datestart = isset($input['datestart']) ? $input['datestart'] : date('Y') . '-01-01';
        // $dateend = isset($input['dateend']) ? $input['dateend'] : date('Y-m-d');
        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
        // $gen = isset($input['gen']) ? $input['gen'] : 'web';
        // $states = Ref::where(['cat' => '17', 'status' => '1'])->pluck('descr', 'code');
        $data['states'] = RefRepository::getList($cat = '17', $sort = 'sort', $lang = 'ms');
        // $state = isset($input['state']) ? $input['state'] : '';
        $data['state'] = $input['state'] ?? null;
        // if ($isSearch) {
        //     switch ($gen) {
        //         case 'xls':
        //             return view('laporan.ad52.list.excelxls',
        //                 compact('request', 'title', 'datestart', 'dateend', 'gen')
        //             );
        //             break;
        //         case 'pdf':
        //             $pdf = PDF::loadView('laporan.ad52.list.pdf',
        //                 compact('request', 'title', 'datestart', 'dateend', 'gen')
        //             );
        //             return $pdf->download($title . date(" YmdHis") . '.pdf');
        //             break;
        //         case 'web':
        //         default:
        //             return view('laporan.ad52.list.index',
        //                 compact('request', 'isSearch', 'title', 'datestart', 'dateend', 'gen', 'states')
        //             );
        //             break;
        //     }
        // }
        if (View::exists('laporan.ad52.list.index')) {
            return view('laporan.ad52.list.index', compact('request', 'data'));
        }
    }

    /**
     * Get DT data
     *
     * @param Request $request
     */
    public function dt(Request $request)
    {
        $input = $request->all();
        // $datestart = isset($input['datestart'])
        //     ? Carbon::parse($input['datestart'])->startOfDay()->toDateTimeString()
        //     : Carbon::now()->startOfDay()->toDateTimeString();
        // $dateend = isset($input['dateend'])
        //     ? Carbon::parse($input['dateend'])->endOfDay()->toDateTimeString()
        //     : Carbon::now()->endOfDay()->toDateTimeString();
        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
        $data['datestartvalidate'] = DateTimeLibrary::validate($data['datestart']);
        $data['dateendvalidate'] = DateTimeLibrary::validate($data['dateend']);
        $data['datetimestart'] = Carbon::parse($data['datestartvalidate'])
            ->startOfDay()->toDateTimeString();
        $data['datetimeend'] = Carbon::parse($data['dateendvalidate'])
            ->endOfDay()->toDateTimeString();
        // $state = isset($input['state']) ? $input['state'] : '';
        $data['state'] = $input['state'] ?? null;
        // $search_ind = isset($input['search_ind']) ? $input['search_ind'] : '0';
        // if ($search_ind) {
        $case_infos = $this->query($data['datetimestart'], $data['datetimeend'], $data['state']);
        // } else {
            // $case_infos = [];
        // }
        $datatables = DataTables::of($case_infos)
            ->addIndexColumn()
            ->editColumn('CA_CASEID', function (Carian $penugasan) {
                return view('aduan.tugas.show_summary_link', compact('penugasan'))->render();
            })
            ->addColumn('department', function ($carian) {
                return Ad52Repository::getAgencyName($carian->CA_MAGNCD);
            })
            ->rawColumns(['CA_CASEID']);
        return $datatables->make(true);
    }

    /**
     * query for get data
     *
     * @param string $datetimestart
     * @param string $datetimeend
     * @param string $state
     */
    public function query($datetimestart, $datetimeend, $state)
    {
        $query = Carian::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->join('sys_ref', 'sys_brn.BR_STATECD', '=', 'sys_ref.code')
                // CASE
                //     WHEN case_info.CA_MAGNCD IS NOT NULL THEN
                //         (SELECT MI_DESC FROM sys_min
                //         WHERE sys_min.MI_MINCD = case_info.CA_MAGNCD)
                //     ELSE 'KPDNHEP'
                // END AS department,
            ->select(DB::raw("
                case_info.CA_CASEID AS CA_CASEID,
                case_info.CA_FILEREF,
                case_info.CA_DEPTCD,
                case_info.CA_RCVDT,
                case_info.CA_FA_DURATION,
                sys_brn.BR_STATECD,
                sys_ref.descr,
                case_info.CA_MAGNCD,
                CASE
                    WHEN case_info.CA_SSP = 'YES' THEN
                        (SELECT sys_ref.descr FROM case_act
                        JOIN sys_ref
                        ON (case_act.CT_AKTA = sys_ref.code
                        AND sys_ref.cat = '713')
                        WHERE CT_CASEID = CA_CASEID
                        LIMIT 1)
                    ELSE ''
                END AS case_act_descr,
                (
                    SELECT
                    a.CD_INVSTS
                    FROM case_dtl a
                    JOIN case_dtl b ON (
                        a.CD_CASEID = b.CD_CASEID
                        AND b.CD_INVSTS = '1'
                    )
                    JOIN case_info ON a.CD_CASEID = case_info.CA_CASEID
                    WHERE a.CD_INVSTS IS NOT NULL
                    AND a.CD_INVSTS NOT IN ('10', '1')
                    AND case_info.CA_CASEID = CA_CASEID
                    ORDER BY
                    a.CD_CREDT
                    LIMIT 1
                ) AS firstactionstatus,
                (
                    SELECT
                    a.CD_REASON_DURATION
                    FROM case_dtl a
                    JOIN case_dtl b ON (
                        a.CD_CASEID = b.CD_CASEID
                        AND b.CD_INVSTS = '1'
                    )
                    JOIN case_info ON a.CD_CASEID = case_info.CA_CASEID
                    WHERE a.CD_INVSTS IS NOT NULL
                    AND a.CD_INVSTS NOT IN ('10', '1')
                    AND case_info.CA_CASEID = CA_CASEID
                    ORDER BY
                    a.CD_CREDT
                    LIMIT 1
                ) AS firstactionduration,
                (
                    SELECT
                    case_reason_templates.descr
                    FROM case_dtl a
                    JOIN case_dtl b ON (
                        a.CD_CASEID = b.CD_CASEID
                        AND b.CD_INVSTS = '1'
                    )
                    JOIN case_info ON a.CD_CASEID = case_info.CA_CASEID
                    LEFT JOIN case_reason_templates ON a.CD_REASON = case_reason_templates.code
                    WHERE a.CD_INVSTS IS NOT NULL
                    AND a.CD_INVSTS NOT IN ('10', '1')
                    AND case_info.CA_CASEID = CA_CASEID
                    AND case_reason_templates.category = 'AD51'
                    ORDER BY
                    a.CD_CREDT
                    LIMIT 1
                ) AS firstactionreason,
                (
                    SELECT
                    a.CD_CREDT
                    FROM case_dtl a
                    JOIN case_dtl b ON (
                        a.CD_CASEID = b.CD_CASEID
                        AND b.CD_INVSTS = '1'
                    )
                    JOIN case_info ON a.CD_CASEID = case_info.CA_CASEID
                    WHERE a.CD_INVSTS IS NOT NULL
                    AND a.CD_INVSTS NOT IN ('10', '1')
                    AND case_info.CA_CASEID = CA_CASEID
                    ORDER BY
                    a.CD_CREDT
                    LIMIT 1
                ) AS firstactiondate,
                CASE
                    WHEN (SELECT
                        a.CD_CREDT
                        FROM
                        case_dtl a
                        JOIN case_dtl b
                            ON (
                                a.CD_CASEID = b.CD_CASEID
                                AND b.CD_INVSTS = '1'
                            )
                        JOIN case_info
                            ON a.CD_CASEID = case_info.CA_CASEID
                        WHERE a.CD_INVSTS IS NOT NULL
                            AND a.CD_INVSTS = '2'
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.CD_CREDT > firstactiondate
                        ORDER BY a.CD_CREDT DESC
                        LIMIT 1
                        ) IS NOT NULL
                    THEN (SELECT
                        a.CD_CREDT
                        FROM
                            case_dtl a
                        JOIN case_dtl b
                            ON (
                                a.CD_CASEID = b.CD_CASEID
                                AND b.CD_INVSTS = '1'
                            )
                        JOIN case_info
                            ON a.CD_CASEID = case_info.CA_CASEID
                        WHERE a.CD_INVSTS IS NOT NULL
                            AND a.CD_INVSTS = '2'
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.CD_CREDT > firstactiondate
                        ORDER BY a.CD_CREDT DESC
                        LIMIT 1)
                    ELSE NULL
                END AS assign_latest_date,
                CASE
                    WHEN (SELECT
                        a.CD_CREDT
                        FROM
                            case_dtl a
                            JOIN case_dtl b
                            ON (
                                a.cd_caseid = b.cd_caseid
                                AND b.cd_invsts = '1'
                            )
                            JOIN case_info
                            ON a.cd_caseid = case_info.CA_CASEID
                        WHERE a.cd_invsts IS NOT NULL
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.cd_credt > assign_latest_date
                            ORDER BY a.cd_credt
                            LIMIT 1
                        ) IS NOT NULL
                    THEN (SELECT
                        a.CD_CREDT
                        FROM
                            case_dtl a
                            JOIN case_dtl b
                            ON (
                                a.cd_caseid = b.cd_caseid
                                AND b.cd_invsts = '1'
                            )
                            JOIN case_info
                            ON a.cd_caseid = case_info.CA_CASEID
                        WHERE a.cd_invsts IS NOT NULL
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.cd_credt > assign_latest_date
                            ORDER BY a.cd_credt
                            LIMIT 1)
                    ELSE NULL
                END AS answer_date,
                CASE
                    WHEN (SELECT
                        a.CD_REASON_DURATION
                        FROM
                            case_dtl a
                            JOIN case_dtl b
                            ON (
                                a.cd_caseid = b.cd_caseid
                                AND b.cd_invsts = '1'
                            )
                        JOIN case_info
                            ON a.cd_caseid = case_info.CA_CASEID
                        WHERE a.cd_invsts IS NOT NULL
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.cd_credt > assign_latest_date
                        ORDER BY a.cd_credt
                        LIMIT 1)
                    THEN
                        (SELECT
                            a.CD_REASON_DURATION
                        FROM
                            case_dtl a
                            JOIN case_dtl b
                            ON (
                                a.cd_caseid = b.cd_caseid
                                AND b.cd_invsts = '1'
                            )
                        JOIN case_info
                            ON a.cd_caseid = case_info.CA_CASEID
                        WHERE a.cd_invsts IS NOT NULL
                            AND case_info.CA_CASEID = CA_CASEID
                            AND a.cd_credt > assign_latest_date
                        ORDER BY a.cd_credt
                        LIMIT 1)
                    ELSE NULL
                END AS answer_duration,
                CASE WHEN (SELECT
                        a.CD_CREDT
                    FROM
                        case_dtl a
                        JOIN case_dtl b
                        ON (
                            a.cd_caseid = b.cd_caseid
                            AND b.cd_invsts = '1'
                        )
                        JOIN case_info
                        ON a.cd_caseid = case_info.CA_CASEID
                    WHERE a.cd_invsts IS NOT NULL
                        AND case_info.CA_CASEID = CA_CASEID
                        AND a.cd_credt > assign_latest_date
                    ORDER BY a.cd_credt
                    LIMIT 1 ) IS NOT NULL
                THEN (SELECT
                        case_reason_templates.descr
                    FROM
                        case_dtl a
                        JOIN case_dtl b
                        ON (
                            a.cd_caseid = b.cd_caseid
                            AND b.cd_invsts = '1'
                        )
                        JOIN case_info
                        ON a.cd_caseid = case_info.CA_CASEID
                        LEFT JOIN case_reason_templates ON a.CD_REASON = case_reason_templates.code
                    WHERE a.cd_invsts IS NOT NULL
                        AND case_info.CA_CASEID = CA_CASEID
                        AND a.cd_credt > assign_latest_date
                        AND case_reason_templates.category = 'AD52'
                    ORDER BY a.cd_credt
                    LIMIT 1)
                ELSE NULL
                END AS answer_reason,
                case_info.CA_COMPLETEDT,
                CASE
                    WHEN case_info.CA_SSP = 'YES' THEN 'YA'
                    ELSE 'TIDAK'
                END AS case_indicator,
                '' AS emptystring
            "))
            ->whereBetween('case_info.CA_RCVDT', [$datetimestart, $datetimeend])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10'],
                ['sys_ref.cat', '=', '17']
            ])
            ->whereNotNull('case_info.CA_RCVDT');
            if(!empty($state)){
                $query = $query->where('sys_brn.BR_STATECD', $state);
            }
            $query = $query->get();
        return $query;
    }
}
