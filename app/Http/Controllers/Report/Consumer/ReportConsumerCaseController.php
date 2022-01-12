<?php

namespace App\Http\Controllers\Report\Consumer;

use App\Http\Controllers\Controller;
use App\Models\Cases\CaseInfo;
use App\Repositories\BranchRepository;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;

/**
 * Aduan Kepenggunaan
 * Laporan Statistik Aduan Menghasilkan Kes Mengikut Negeri & Cawangan
 */
class ReportConsumerCaseController extends Controller
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

        $data['title'] = 'Laporan Statistik Aduan Menghasilkan Kes Mengikut Negeri & Cawangan';
        $data['states'] = RefRepository::getList($cat = '17', $sort = 'sort', $lang = 'ms');
        $data['categories'] = RefRepository::getList($cat = '244', $sort = 'sort', $lang = 'ms');

        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');

        $data['generate'] = $input['generate'] ?? null;

        if ($data['issearch']) {
            $data['appname'] = config('app.name', 'eAduan 2.0');
            $data['currentdatetime'] = Carbon::now()->format('YmdHis');
            $data['filename'] = ($data['appname'] ?? '') . ' ' . ($data['title'] ?? '') . ' '
                . ($data['currentdatetime'] ?? '');

            $data['datetimestart'] = Carbon::createFromFormat('d-m-Y', $data['datestart'])
                ->startOfDay()->toDateTimeString();
            $data['datetimeend'] = Carbon::createFromFormat('d-m-Y', $data['dateend'])
                ->endOfDay()->toDateTimeString();
            $data['datetext'] = 'Tarikh Penerimaan : Dari ' . ($data['datestart'] ?? '') . ' Hingga '
                . ($data['dateend'] ?? '');

            $data['state'] = $input['state'] ?? null;
            $data['statedescription'] = RefRepository::getDescr('17', ($data['state'] ?? ''), 'ms');
            $data['statetext'] = 'Negeri : ' . ($data['statedescription'] ?? '');
            $data['statefilter'] = $data['states']->has($data['state']);

            $data['category'] = $input['category'] ?? null;
            $data['categorydescription'] = RefRepository::getDescr('244', ($data['category'] ?? ''), 'ms');
            $data['categorytext'] = 'Kategori : ' . ($data['categorydescription'] ?? '');
            $data['categoryfilter'] = $data['categories']->has($data['category']);

            $data['headings'] = ['Bil.', 'Nama Cawangan', 'Jumlah Aduan Diterima',
                'Aduan Menghasilkan Kes', 'Aduan Tidak Menghasilkan Kes'];

            $data['template'] = ['totalconsumercase' => 0, 'totalbecomecase' => 0, 'totalnotbecomecase' => 0];

            $data['countTotal'] = $data['template'];

            $data['consumercases'] = self::query($input, $data);
            $data['consumerbecomecases'] = self::query2($input, $data);
            $data['consumernotbecomecases'] = self::query3($input, $data);

            foreach ($data['consumercases'] as $key => $branch) {
                $branch->branchCode = $branch->CA_BRNCD ?? $branch['CA_BRNCD'] ?? $key ?? '';
                $branch->branchCodeTrim = trim($branch->branchCode);
                $branch->stateCode = $branch->BR_STATECD ?? $branch['BR_STATECD'] ?? '';
                foreach ($data['template'] as $keyTemplate => $template) {
                    $data['count'][$branch->branchCodeTrim][$keyTemplate] = $template;
                }
                $data['count'][$branch->branchCodeTrim]['branchCode'] = $branch->branchCodeTrim;
                $data['count'][$branch->branchCodeTrim]['branchName'] = BranchRepository::getName($branch->branchCodeTrim);
                $data['count'][$branch->branchCodeTrim]['stateCode'] = $branch->stateCode;
                $data['count'][$branch->branchCodeTrim]['stateName'] = RefRepository::getDescr('17', $branch->stateCode, 'ms');

                $branch->countAllCaseId = $branch->countCaseId ?? $branch['countCaseId'] ?? 0;
                $data['count'][$branch->branchCodeTrim]['totalconsumercase'] = $branch->countAllCaseId;
                $data['countTotal']['totalconsumercase'] += $branch->countAllCaseId;
            }
            foreach ($data['consumerbecomecases'] as $key => $branch) {
                $branch->caseBranchCode = $branch->CA_BRNCD ?? $branch['CA_BRNCD'] ?? $key ?? '';
                $branch->caseBranchCodeTrim = trim($branch->caseBranchCode);
                $branch->countCaseIds = $branch->countCaseId ?? $branch['countCaseId'] ?? 0;
                $data['count'][$branch->caseBranchCodeTrim]['totalbecomecase'] = $branch->countCaseIds;
                $data['countTotal']['totalbecomecase'] += $branch->countCaseIds;
            }
            foreach ($data['consumernotbecomecases'] as $key => $branch) {
                $branch->notCaseBranchCode = $branch->CA_BRNCD ?? $branch['CA_BRNCD'] ?? $key ?? '';
                $branch->notCaseBranchCodeTrim = trim($branch->notCaseBranchCode);
                $branch->countNotCaseIds = $branch->countCaseId ?? $branch['countCaseId'] ?? 0;
                $data['count'][$branch->notCaseBranchCodeTrim]['totalnotbecomecase'] = $branch->countNotCaseIds;
                $data['countTotal']['totalnotbecomecase'] += $branch->countNotCaseIds;
            }
            if(isset($data['count'])) {
                // prepare for sort the data by state code
                array_multisort(array_column($data['count'], 'stateCode'), $data['count']);
            }
            $data['urldetail'] = '/report/consumer/casedetail' . '?' . explode('?', url()->full())[1] ?? '';
        }
        switch ($data['generate']) {
            case 'excel':
                return Excel::create($data['filename'] ?? $data['generate'], function ($excel) use ($request, $data) {
                    $excel->sheet('Laporan', function ($sheet) use ($request, $data) {
                        $sheet->loadView('report.consumer.case.excel')
                            ->with(['request' => $request, 'data' => $data]);
                    });
                })->export('xlsx');
                break;
            case 'pdf':
                return PDF::loadView('report.consumer.case.pdf', compact('request', 'data'))
                    ->download(($data['filename'] ?? $data['generate']). '.' . $data['generate']);
                break;
            default:
                return view('report.consumer.case.index', compact('request', 'data'));
                break;
        }
    }

    /**
     * query for get data
     *
     * @param array $input
     * @param array $data
     * @return CaseInfo[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query(array $input, array $data)
    {
        $query = CaseInfo::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->select('case_info.CA_BRNCD', 'sys_brn.BR_STATECD', DB::raw('count(case_info.CA_CASEID) as countCaseId'))
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_BRNCD', '<>', null],
                ['case_info.CA_BRNCD', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10']
            ]);

        if(isset($data['statefilter']) && $data['statefilter'] && isset($data['state']) && !empty($data['state'])) {
            $query->where('sys_brn.BR_STATECD', $data['state']);
        }

        if(isset($data['categoryfilter']) && $data['categoryfilter'] && isset($data['category']) && !empty($data['category'])) {
            $query->where('case_info.CA_CMPLCAT', $data['category']);
        }

        // $query = $query->groupBy('case_info.CA_BRNCD')->get();
        $query = $query->groupBy('case_info.CA_BRNCD', 'sys_brn.BR_STATECD')->get();

        return $query;
    }

    /**
     * query to get data from case info where become case
     *
     * @param array $input
     * @param array $data
     * @return CaseInfo[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query2(array $input, array $data)
    {
        $query = CaseInfo::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->select(DB::raw('count(case_info.CA_CASEID) as countCaseId'), 'case_info.CA_BRNCD')
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_BRNCD', '<>', null],
                ['case_info.CA_BRNCD', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10'],
                ['case_info.CA_SSP', '=', 'YES']
            ]);

        if(isset($data['statefilter']) && $data['statefilter'] && isset($data['state']) && !empty($data['state'])) {
            $query->where('sys_brn.BR_STATECD', $data['state']);
        }

        if(isset($data['categoryfilter']) && $data['categoryfilter'] && isset($data['category']) && !empty($data['category'])) {
            $query->where('case_info.CA_CMPLCAT', $data['category']);
        }

        $query = $query->groupBy('case_info.CA_BRNCD')->get();

        return $query;
    }

    /**
     * query to get data from case info where not become case
     *
     * @param array $input
     * @param array $data
     * @return CaseInfo[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query3(array $input, array $data)
    {
        $query = CaseInfo::join('sys_brn', 'case_info.CA_BRNCD', '=', 'sys_brn.BR_BRNCD')
            ->select(DB::raw('count(case_info.CA_CASEID) as countCaseId'), 'case_info.CA_BRNCD')
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_BRNCD', '<>', null],
                ['case_info.CA_BRNCD', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10']
            ])
            ->where(function ($query) {
                $query->whereNull('case_info.CA_SSP')
                    ->orWhere('case_info.CA_SSP', '=', '')
                    ->orWhere('case_info.CA_SSP', '=', 'NO')
                    ->orWhere('case_info.CA_SSP', '!=', 'YES');
            });

        if(isset($data['statefilter']) && $data['statefilter'] && isset($data['state']) && !empty($data['state'])) {
            $query->where('sys_brn.BR_STATECD', $data['state']);
        }

        if(isset($data['categoryfilter']) && $data['categoryfilter'] && isset($data['category']) && !empty($data['category'])) {
            $query->where('case_info.CA_CMPLCAT', $data['category']);
        }

        $query = $query->groupBy('case_info.CA_BRNCD')->get();

        return $query;
    }
}
