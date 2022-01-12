<?php

namespace App\Repositories\ConsumerComplaint;

use App\Branch;
use App\Holiday;
use App\Models\Cases\CaseInfo;
use App\Wd;
use Cache;
use Carbon\Carbon;
use DB;
use Storage;

/**
 * Class CaseInfoRepository
 * @package App\Repositories\ConsumerComplaint
 */
class CaseInfoRepository
{
    /**
     * Configure the Model
     * @return string
     */
    public function model()
    {
        return CaseInfo::class;
    }

    /**
     * @return mixed
     */
    // public static function getAll()
    // {
    //     return Cache::remember('case_info:all', 1, function () {
    //         return CaseInfo::all();
    //     });
    // }

    /**
     * @return mixed
     */
    public static function getOne($caseId)
    {
        return Cache::remember('case_info:'.$caseId, 1, function () use ($caseId) {
            return CaseInfo::where('CA_CASEID', $caseId)->first();
        });
    }

    /**
     * To route consumer complaint to responsible branch.
     * @param $StateCd
     * @param $DistCd
     * @param $DeptCd
     * @param $RouteToHQ
     * @return string
     */
    public static function routeBranch($StateCd, $DistCd, $DeptCd, $RouteToHQ = false)
    {
        if ($DeptCd == 'BPGK') {
            if ($StateCd == '16') {
                $FindBrn = DB::table('sys_brn')
                    ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                    ->where('BR_STATECD', $StateCd)
                    ->where(DB::raw("LOCATE(CONCAT(',', '$DistCd' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                    ->where('BR_DEPTCD', 'BGK')
                    ->where('BR_STATUS', 1)
                    ->first();
            } else {
                $FindBrn = DB::table('sys_brn')
                    ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                    ->where('BR_STATECD', $StateCd)
                    ->where(DB::raw("LOCATE(CONCAT(',', '$DistCd' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                    ->where('BR_DEPTCD', $DeptCd)
                    ->where('BR_STATUS', 1)
                    ->first();
            }
            if ($RouteToHQ) {
                return 'WHQR5';
            } else {
                if(!empty($FindBrn)){
                    return $FindBrn->BR_BRNCD;
                } else {
                    return 'WHQR5';
                }
            }
        } else {
            $FindBrn = DB::table('sys_brn')
                ->select('BR_BRNCD', 'BR_BRNNM', 'BR_OTHDIST')
                ->where('BR_STATECD', 16)
                ->where(DB::raw("LOCATE(CONCAT(',', '1601' ,','),CONCAT(',',BR_OTHDIST,','))"), ">", 0)
                ->where('BR_DEPTCD', $DeptCd)
                ->where('BR_STATUS', 1)
                ->first();
            if(!empty($FindBrn)){
                return $FindBrn->BR_BRNCD;
            } else {
                return 'WHQR5';
            }
        }
    }

    /**
     * To generate log file on user store / update draft consumer complaint
     * @param $arrayInput
     * @return mixed
     */
    public static function setSubCategoryLog($arrayInput)
    {
        $caseInfoUpdatedById = $arrayInput['caseInfoUpdatedById'] ?? '';
        $caseInfoId = $arrayInput['caseInfoId'] ?? '';
        $caseInfoInvestigationStatusCode = $arrayInput['caseInfoInvestigationStatusCode'] ?? '';
        $caseInfoReceivedTypeCode = $arrayInput['caseInfoReceivedTypeCode'] ?? '';
        $CA_CMPLCAT = $arrayInput['CA_CMPLCAT'] ?? '';
        $CA_CMPLCD = $arrayInput['CA_CMPLCD'] ?? '';
        $validateSubCategoryCode = $arrayInput['validateSubCategoryCode'] ?? '';

        $contents = date('Y-m-d H:i:s') . '|'
            . $caseInfoUpdatedById . '|'
            . $caseInfoId . '|'
            . $caseInfoInvestigationStatusCode . '|'
            . $caseInfoReceivedTypeCode . '|'
            . $CA_CMPLCAT . '|'
            . $CA_CMPLCD . '|'
            . $validateSubCategoryCode;

        return Storage::append('api/log-public-consumer-complaint-draft-'.date('Y-m-d').'.txt', $contents);
    }

    /**
     * To count number of duration days of investigation
     * @param $caseId
     * @return int
     */
    public static function getDuration($caseId)
    {
        $holiday = new Holiday();
        $workingDay = new Wd();

        $caseInfo = self::getOne($caseId);
        $stateCode = $caseInfo->CA_AGAINST_STATECD ?? $caseInfo->CA_STATECD ?? 16;

        $startCarbon = Carbon::parse($caseInfo->CA_RCVDT);
        $startDateString = $startCarbon->toDateString();

        $endCarbon = Carbon::today();
        $endDateString = $endCarbon->toDateString();

        // DAPATKAN HARI CUTI MINGGUAN MENGIKUT NEGERI
        $offDay = $workingDay->offDay($stateCode);

        // KIRAAN CUTI MENGIKUT NEGERI
        $holidayDay = $holiday->off($startDateString, $endDateString, $stateCode);

        // KIRAAN CUTI BERULANG MENGIKUT NEGERI
        $repeatHoliday = $holiday->repeatedOffday($startDateString, $endDateString, $stateCode);

        // KIRAAN CUTI MINGGUAN DALAM MENGIKUT NEGERI
        $duration = $workingDay->getWorkingDay($startDateString, $endDateString, $offDay);

        // CUTI DALAM TEMPOH ADUAN
        $totalDuration = $duration - ($holidayDay + $repeatHoliday);

        if ($totalDuration < 0) {
            $totalDuration = 0;
        }

        return $totalDuration;
    }
}