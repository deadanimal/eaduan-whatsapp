<?php

namespace App\Http\Controllers\Report\Consumer;

use App\Aduan\Carian;
use App\Http\Controllers\Controller;
use App\Models\Cases\CaseInfo;
use App\Repositories\BranchRepository;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;
use Yajra\DataTables\Facades\DataTables;

/**
 * Aduan Kepenggunaan
 * Laporan Statistik Aduan Menghasilkan Kes Mengikut Negeri & Cawangan
 * ( Maklumat Terperinci )
 */
class ReportConsumerCaseDetailController extends Controller
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

        $data['title'] = 'Laporan Statistik Aduan Menghasilkan Kes Mengikut Negeri & Cawangan ( Maklumat Terperinci )';

        $data['generate'] = $input['generate'] ?? null;

        if ($data['issearch']) {
            $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
            $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');
            $data['datetext'] = 'Tarikh Penerimaan : Dari ' . ($data['datestart'] ?? '') . ' Hingga '
                . ($data['dateend'] ?? '');

            $data['state'] = $input['state'] ?? null;
            $data['statedescription'] = RefRepository::getDescr('17', ($data['state'] ?? ''), 'ms');
            $data['statetext'] = 'Negeri : ' . ($data['statedescription'] ?? '');

            $data['category'] = $input['category'] ?? null;
            $data['categorydescription'] = RefRepository::getDescr('244', ($data['category'] ?? ''), 'ms');
            $data['categorytext'] = 'Kategori : ' . ($data['categorydescription'] ?? '');

            $data['branch'] = $input['branch'] ?? null;
            $data['branchdescription'] = BranchRepository::getName($data['branch']);
            $data['branchtext'] = 'Cawangan : ' . ($data['branchdescription'] ?? '');

            $data['case'] = $input['case'] ?? null;
            if($data['case'] == '1') {
                $data['casetext'] = 'Aduan Menghasilkan Kes';
            } else if($data['case'] == '2') {
                $data['casetext'] = 'Aduan Tidak Menghasilkan Kes';
            } 
        }
        if (View::exists('report.consumer.casedetail.index')) {
            return view('report.consumer.casedetail.index', compact('request', 'data'));
        }
    }

    /**
     * Query for get data.
     *
     * @param array $data
     * @return mixed
     */
    public function query(array $data)
    {
        $que = Carian::join('sys_brn as b', 'case_info.CA_BRNCD', '=', 'b.BR_BRNCD')
            ->select(
                'case_info.CA_CASEID', 'case_info.CA_SUMMARY', 'case_info.CA_NAME',
                'case_info.CA_AGAINSTNM', 'b.BR_BRNNM', 'case_info.CA_CMPLCAT',
                'case_info.CA_RCVDT', 'case_info.CA_COMPLETEDT', 'case_info.CA_CLOSEDT',
                'case_info.CA_INVBY'
            )
            ->where([
                ['CA_CASEID', '<>', null],
                ['CA_RCVTYP', '<>', null],
                ['CA_RCVTYP', '<>', ''],
                ['CA_CMPLCAT', '<>', ''],
                ['CA_INVSTS', '!=', '10']
            ])
            ->whereNotNull('case_info.CA_RCVDT')
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']]);
            if (!empty($data['state'])) {
                $que->where('b.BR_STATECD', '=', $data['state']);
            }
            if (!empty($data['branch'])) {
                $que->where('b.BR_BRNCD', '=', $data['branch']);
            }
            if(isset($data['category']) && !empty($data['category'])) {
                $que->where('case_info.CA_CMPLCAT', $data['category']);
            }
            if ($data['case'] == '1') {
                $que->where('case_info.CA_SSP', '=', 'YES');
            }
            elseif ($data['case'] == '2') {
                $que->where(function ($query) {
                    $query->whereNull('case_info.CA_SSP')
                        ->orWhere('case_info.CA_SSP', '=', '')
                        ->orWhere('case_info.CA_SSP', '=', 'NO');
                });
            }
            $que->orderBy('CA_RCVDT', 'desc');

        return $que;
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

        $data['datetimestart'] = Carbon::createFromFormat('d-m-Y', $data['datestart'])
            ->startOfDay()->toDateTimeString();
        $data['datetimeend'] = Carbon::createFromFormat('d-m-Y', $data['dateend'])
            ->endOfDay()->toDateTimeString();

        $data['state'] = $input['state'] ?? null;

        $data['category'] = $input['category'] ?? null;

        $data['branch'] = $input['branch'] ?? null;

        $data['case'] = $input['case'] ?? null;

        $data['consumercases'] = self::query($data);

        $datatables = DataTables::of($data['consumercases'])
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
}
