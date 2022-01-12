<?php

namespace App\Http\Controllers\Report\Consumer;

use App\Http\Controllers\Controller;
use App\Libraries\DateTimeLibrary;
use App\Models\Cases\CaseInfo;
use App\Repositories\Ref\RefRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;
use View;

/**
 * Aduan Kepenggunaan
 * Laporan Pembekal Perkhidmatan Mengikut Status
 */
class ReportConsumerServiceProviderController extends Controller
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
     * GET /report/consumer/serviceprovider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $data['issearch'] = count($input) > 0 ? true : false;

        $data['title'] = 'Laporan Pembekal Perkhidmatan Mengikut Status';

        $data['datestart'] = $input['datestart'] ?? Carbon::today()->format('d-m-Y');
        $data['dateend'] = $input['dateend'] ?? Carbon::today()->format('d-m-Y');

        $data['categories'] = RefRepository::getList($cat = '244', $sort = 'sort', $lang = 'ms');

        $data['generate'] = $input['generate'] ?? null;

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

            $data['category'] = $input['category'] ?? null;
            $data['categorydescription'] = RefRepository::getDescr('244', ($data['category'] ?? ''), 'ms');
            $data['categorytext'] = 'Kategori : ' . ($data['categorydescription'] ?? '');
            $data['categoryfilter'] = $data['categories']->has($data['category']);

            $data['appname'] = config('app.name', 'eAduan 2.0');
            $data['currentdatetime'] = Carbon::now()->format('YmdHis');
            $data['filename'] = ($data['appname'] ?? '') . ' ' . ($data['title'] ?? '') . ' '
                . ($data['currentdatetime'] ?? '');

            $data['consumercases'] = self::query($data);

            $data['headings'] = ['Bil.', 'Pembekal Perkhidmatan', 'Aduan Diterima',
                'Aduan Baru', 'Dalam Siasatan', 'Maklumat Tidak Lengkap', 'Selesai',
                'Ditutup', 'Rujuk Agensi', 'Rujuk Tribunal', 'Pertanyaan', 'Luar Bidang Kuasa'];

            $data['template'] = [
                'selesai' => 0,
                'belum agih' => 0,
                'dalam siasatan' => 0,
                'tutup' => 0,
                'agensi lain' => 0,
                'tribunal' => 0,
                'pertanyaan' => 0,
                'maklumat tak lengkap' => 0,
                'luar bidang' => 0,
                'total' => 0,
            ];
            $data['counttotal'] = $data['template'];

            foreach ($data['consumercases'] as $key => $value) {
                $data['count'][$value->CA_ONLINECMPL_PROVIDER] = $data['template'];
                $data['count'][$value->CA_ONLINECMPL_PROVIDER] = [
                    'selesai' => $value->SELESAI + $value->SELESAIMAKLUMATXLENGKAP,
                    'belum agih' => $value->BELUMAGIH,
                    'dalam siasatan' => $value->DALAMSIASATAN,
                    'tutup' => $value->TUTUP + $value->TUTUPMAKLUMATXLENGKAP,
                    'agensi lain' => $value->AGENSILAIN,
                    'tribunal' => $value->TRIBUNAL,
                    'pertanyaan' => $value->PERTANYAAN,
                    'maklumat tak lengkap' => $value->MKLUMATXLENGKAP,
                    'luar bidang' => $value->LUARBIDANG,
                    'total' => $value->total,
                ];
                $data['count'][$value->CA_ONLINECMPL_PROVIDER]['provider'] = RefRepository::getDescr('1091', ($value->CA_ONLINECMPL_PROVIDER ?? ''), 'ms');
                $data['counttotal']['selesai'] += $value->SELESAI + $value->SELESAIMAKLUMATXLENGKAP;
                $data['counttotal']['belum agih'] += $value->BELUMAGIH;
                $data['counttotal']['dalam siasatan'] += $value->DALAMSIASATAN;
                $data['counttotal']['tutup'] += $value->TUTUP + $value->TUTUPMAKLUMATXLENGKAP;
                $data['counttotal']['agensi lain'] += $value->AGENSILAIN;
                $data['counttotal']['tribunal'] += $value->TRIBUNAL;
                $data['counttotal']['pertanyaan'] += $value->PERTANYAAN;
                $data['counttotal']['maklumat tak lengkap'] += $value->MKLUMATXLENGKAP;
                $data['counttotal']['luar bidang'] += $value->LUARBIDANG;
                $data['counttotal']['total'] += $value->total;
            }
        }

        switch ($data['generate']) {
            case 'excel':
                return Excel::create($data['filename'] ?? $data['generate'], function ($excel) use ($request, $data) {
                    $excel->sheet('Laporan', function ($sheet) use ($request, $data) {
                        $sheet->loadView('report.consumer.serviceprovider.excel')
                            ->with(['request' => $request, 'data' => $data]);
                    });
                })->export('xlsx');
                break;
            case 'pdf':
                return PDF::loadView('report.consumer.serviceprovider.pdf', compact('request', 'data'))
                    ->download(($data['filename'] ?? $data['generate']). '.' . $data['generate']);
                break;
            default:
                if (View::exists('report.consumer.serviceprovider.index')) {
                    return view('report.consumer.serviceprovider.index', compact('request', 'data'));
                }
                break;
        }
    }

    /**
     * Query for get data.
     *
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    public function query(array $data)
    {
        $query = CaseInfo::select(
                'case_info.CA_ONLINECMPL_PROVIDER',
                DB::raw('
                    count(case_info.CA_CASEID) as total,
                    SUM(CASE WHEN case_info.CA_INVSTS = 3 THEN 1 ELSE 0 END) AS SELESAI,
                    SUM(CASE WHEN case_info.CA_CASESTS = 1 THEN 1 ELSE 0 END) AS BELUMAGIH,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 2 THEN 1 ELSE 0 END) AS DALAMSIASATAN,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 9 THEN 1 ELSE 0 END) AS TUTUP,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 4 THEN 1 ELSE 0 END) AS AGENSILAIN,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 5 THEN 1 ELSE 0 END) AS TRIBUNAL,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 6 THEN 1 ELSE 0 END) AS PERTANYAAN,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 7 THEN 1 ELSE 0 END) AS MKLUMATXLENGKAP,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 8 THEN 1 ELSE 0 END) AS LUARBIDANG,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 12 THEN 1 ELSE 0 END) AS SELESAIMAKLUMATXLENGKAP,
                    SUM(CASE WHEN case_info.CA_CASESTS = 2 AND case_info.CA_INVSTS = 11 THEN 1 ELSE 0 END) AS TUTUPMAKLUMATXLENGKAP
                ')
            )
            ->whereBetween('case_info.CA_RCVDT', [$data['datetimestart'], $data['datetimeend']])
            ->where([
                ['case_info.CA_CASEID', '<>', null],
                ['case_info.CA_RCVTYP', '<>', null],
                ['case_info.CA_RCVTYP', '<>', ''],
                ['case_info.CA_CMPLCAT', '<>', ''],
                ['case_info.CA_INVSTS', '!=', '10']
            ])
            ->whereNotNull('case_info.CA_ONLINECMPL_PROVIDER');

        if(isset($data['categoryfilter']) && $data['categoryfilter'] && isset($data['category']) && !empty($data['category'])) {
            $query->where('case_info.CA_CMPLCAT', $data['category']);
        }

        $query = $query->groupBy('case_info.CA_ONLINECMPL_PROVIDER')->get();
        return $query;
    }
}
